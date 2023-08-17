import { locales } from '$lib/translations';
export const urlsPerSitemap = Math.floor(50000 / locales.get().length);
