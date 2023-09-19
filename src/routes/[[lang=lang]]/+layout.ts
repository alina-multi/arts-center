import { defaultLocale, loadTranslations } from '$lib/translations';
import type { LayoutLoad } from './$types';

export const load = (async ({ params, url }) => {
	const initLocale = params.lang || defaultLocale; // set default if no locale already set
	await loadTranslations(initLocale, url.pathname); // keep this just before the `return`
	return {};
}) satisfies LayoutLoad;
