import { defaultLocale, loadTranslations } from '$lib/translations';
import type { LayoutLoad } from './$types';

export const load = (async (event) => {
  const initLocale = event.params.lang || defaultLocale; // set default if no locale already set
  await loadTranslations(initLocale, event.url.pathname); // keep this just before the `return`
  return {};
}) satisfies LayoutLoad;
