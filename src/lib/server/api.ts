import type { RequestEvent } from '@sveltejs/kit';
import setCookie from 'set-cookie-parser';

interface ApiParams {
	method: string;
	event?: RequestEvent;
	path: string;
	data?: Record<string, unknown> | null;
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
			cookie: params?.event?.request?.headers?.get('cookie') as string
		},
		body: params.data && JSON.stringify(params.data)
	});
	proxyCookies(params.event, response);
	return response;
}

// Check to see that client has XSRF-TOKEN cookie, if not, get it from laravel and pass it back to client
export async function csrf(event: RequestEvent) {
	if (!event?.cookies?.get('XSRF-TOKEN')) {
		const sanctum = await api({ method: 'GET', path: '/auth/sanctum/csrf-cookie', event });
	}
}

export function proxyCookies(event: RequestEvent, response: Response) {
	var combinedCookieHeader = response.headers.get('Set-Cookie');
	var splitCookieHeaders = setCookie.splitCookiesString(combinedCookieHeader);
	var cookies = setCookie.parse(splitCookieHeaders);
	cookies?.forEach(
		(cookie: { name: string; value: string; path: any; expires: any; httpOnly: any }) => {
			event.cookies.set(cookie.name, cookie.value, {
				path: cookie.path,
				expires: cookie.expires,
				httpOnly: cookie.httpOnly
			});
		}
	);
}
