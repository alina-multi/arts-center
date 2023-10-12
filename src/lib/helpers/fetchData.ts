import loading from '$lib/stores/loading';
import toast from 'svelte-french-toast';
import { defaultLocale, t, locale } from '$lib/translations';
import { captureException } from '@sentry/svelte';

export function fetchData(method: string, url: string, body: object = {}) {
	return fetch(url, {
		method,
		headers: {
			'Content-Type': 'application/json',
			'Accept-Language': locale.get() || defaultLocale
		},
		body: JSON.stringify(body)
	});
}

export async function magicFetch(method: string, url: string, body: object = {}, loader = true) {
	if (loader) {
		loading.set(true);
	}
	try {
		const response = await fetchData(method, url, body);
		let json = {};
		if (response.status !== 204) {
			json = await response.json();
		}
		if (!response.ok) {
			throw new Error(json?.message || t.get('global.error.api'));
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
