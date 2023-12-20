import type { Config } from 'sveltekit-i18n';
import i18n from 'sveltekit-i18n';
import lang from './lang.json';
import type { RequestEvent } from '@sveltejs/kit';
import { error, redirect } from '@sveltejs/kit';
import type { Translatable } from '../interfaces/Translatable';

// todo: fix lazy loading
// maybe use https://poly-i18n.vercel.app/en/kitbook
const config: Config = {
	translations: {
		en: { lang },
		uk: { lang }
	},
	loaders: [
		{
			locale: 'en',
			key: 'global',
			loader: async () => (await import('./en/global.json')).default
		},
		{
			locale: 'uk',
			key: 'global',
			loader: async () => (await import('./uk/global.json')).default
		},
		{
			locale: 'en',
			key: 'my',
			//routes: [/\/my\/.*/],
			loader: async () => (await import('./en/my.json')).default
		},
		{
			locale: 'uk',
			key: 'my',
			//routes: [/\/uk\/my\/.*/],
			loader: async () => (await import('./uk/my.json')).default
		},
		{
			locale: 'en',
			key: 'static',
			//routes: [/\/s\/about/],
			loader: async () => (await import('./en/static.json')).default
		},
		{
			locale: 'uk',
			key: 'static',
			//routes: [/\/uk\/s\/about/],
			loader: async () => (await import('./uk/static.json')).default
		}
	]
};

export const defaultLocale = 'en';

export const availableLocales = ['en', 'uk'] as const;

export function correctLocale(lang: (typeof availableLocales)[number]): boolean {
	return availableLocales.includes(lang);
}

export function checkUrlLocale(event: RequestEvent): (typeof availableLocales)[number] {
	const lang = event.params.lang || defaultLocale;
	if (!correctLocale(lang)) {
		throw error(404, {
			message: 'Language not supported'
		});
	}
	if (event.url.pathname.startsWith(`/${defaultLocale}`)) {
		const newUrl = event.url.pathname.replace(`/${defaultLocale}`, '') || '/';
		throw redirect(301, newUrl);
	}
	return lang;
}

export function localePath(
	currentLang: (typeof availableLocales)[number],
	path: `/${string}`
): string {
	return removeTrailingSlash(localPrefix(currentLang) + path);
}

export function switchLocalePath(
	currentLang: (typeof availableLocales)[number],
	newLang: (typeof availableLocales)[number],
	path: string
): string {
	const pathWithoutLocale = path.replace(localPrefix(currentLang), '');
	return removeTrailingSlash(localPrefix(newLang) + pathWithoutLocale || '/');
}

export function localPrefix(lang: (typeof availableLocales)[number]): string {
	return lang === defaultLocale ? '' : `/${lang}`;
}

function removeTrailingSlash(str: string): string {
	return str.endsWith('/') && str.length > 1 ? str.slice(0, -1) : str;
}

export async function loadTranslations(lang: (typeof availableLocales)[number], route: string) {
	const instance = new i18n(config);
	await instance.loadTranslations(lang, route);
	return {
		t: instance.t,
		locale: instance.locale
	};
}

export function languageFilter<Type extends Translatable>(
	rows: Type[] | undefined,
	lang: (typeof availableLocales)[number]
): Type[] {
	return (
		rows?.filter((row) => {
			// By convention language zz means show on all languages
			return row.language == lang || row.language == 'zz';
		}) || []
	);
}

export function languageFind<Type extends Translatable>(
	rows: Type[] | undefined,
	lang: (typeof availableLocales)[number]
): Type | undefined {
	return rows?.find((row) => row.language == lang);
}
