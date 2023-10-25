import type { RequestEvent } from '@sveltejs/kit';
import setCookie from 'set-cookie-parser';
import { availableLocales, defaultLocale } from '$lib/translations';

interface ApiParams {
	method: string;
	event: RequestEvent;
	path: string;
	data?: object | null;
}

export async function api(params: ApiParams) {
	const base = process.env.API_URL;
	const url = base + params.path;
	const response = await fetch(url, {
		method: params.method,
		headers: {
			'content-type': 'application/json',
			accept: 'application/json',
			referer: url, // Laravel Sanctum needs this
			'X-XSRF-TOKEN': params?.event?.cookies?.get('XSRF-TOKEN') as string,
			cookie: params?.event?.request?.headers?.get('cookie') as string,
			// It's possible that app still haven't selected the locale by this point
			'Accept-Language': params?.event?.params?.lang || defaultLocale
		},
		body: JSON.stringify(params.data)
	});
	proxyCookies(params.event, response);
	return response;
}

// Check to see that client has XSRF-TOKEN cookie, if not, get it from laravel and pass it back to client
export async function csrf(event: RequestEvent) {
	await api({ method: 'GET', path: '/auth/sanctum/csrf-cookie', event });
}

export function proxyCookies(event: RequestEvent, response: Response) {
	const combinedCookieHeader = response.headers.get('Set-Cookie');
	const splitCookieHeaders = setCookie.splitCookiesString(combinedCookieHeader);
	const cookies = setCookie.parse(splitCookieHeaders);
	cookies?.forEach(
		(cookie: { name: string; value: string; path: string; expires: string; httpOnly: boolean }) => {
			event?.cookies?.set(cookie.name, cookie.value, {
				path: cookie.path,
				expires: cookie.expires,
				httpOnly: cookie.httpOnly
			});
		}
	);
}

export async function proxyApi(event: RequestEvent) {
	const data = await event.request.json();
	const reqUrl = new URL(event.request.url);
	let path = reqUrl.pathname.replace('/api', '/api2');
	for (const locale of availableLocales) {
		path = path.replace(`/${locale}/`, '/');
	}

	const response = await api({
		method: event.request.method,
		path,
		data,
		event
	});

	return new Response(await response.text());
}
