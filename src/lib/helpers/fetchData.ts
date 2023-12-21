import loading from '$lib/stores/loading';
import toast from 'svelte-french-toast';
import { defaultLocale } from '$lib/translations';
import { captureException } from '@sentry/svelte';

export function fetchData(method: string, url: string, body: object = {}, locale = defaultLocale) {
	return fetch(url, {
		method,
		headers: {
			'Content-Type': 'application/json',
			'Accept-Language': locale || defaultLocale
		},
		body: JSON.stringify(body)
	});
}

export async function magicFetch(
	method: string,
	url: string,
	body: object = {},
	loader = true,
	locale = defaultLocale
) {
	if (loader) {
		loading.set(true);
	}
	try {
		const response = await fetchData(method, url, body, locale);
		let json = {};
		if (response.status !== 204) {
			json = await response.json();
		}
		if (!response.ok) {
			throw new Error(json?.message || 'Unknown API server error');
		}
		if (loader) {
			loading.set(false);
		}
		return json;
	} catch (e) {
		if (loader) {
			loading.set(false);
		}
		toast.error(e.message);
		captureException(e);
		throw e;
	}
}
