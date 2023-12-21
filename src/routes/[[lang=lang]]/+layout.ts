import { defaultLocale, loadTranslations } from '$lib/translations';
import type { LayoutLoad } from './$types';

export const load = (async ({ params, url }) => {
	const initLocale = params.lang || defaultLocale; // set default if no locale already set
	return await loadTranslations(initLocale, url.pathname);
}) satisfies LayoutLoad;
