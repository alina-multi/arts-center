import type { Config } from 'sveltekit-i18n';
import i18n from 'sveltekit-i18n';
import lang from './lang.json';
import type { RequestEvent } from '@sveltejs/kit';
import { error, redirect } from '@sveltejs/kit';
import type { Translatable } from '../interfaces/Translatable';

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
			routes: [/\/my\/.*/],
			loader: async () => (await import('./en/my.json')).default
		},
		{
			locale: 'uk',
			key: 'my',
			routes: [/\/uk\/my\/.*/],
			loader: async () => (await import('./uk/my.json')).default
		},
		{
			locale: 'en',
			key: 'static',
			routes: [/\/s\/about/],
			loader: async () => (await import('./en/static.json')).default
		},
		{
			locale: 'uk',
			key: 'static',
			routes: [/\/uk\/s\/about/],
			loader: async () => (await import('./uk/static.json')).default
		}
	]
};

export const defaultLocale = 'en';

export const availableLocales = ['en', 'uk'];

export function correctLocale(lang: string): boolean {
	return availableLocales.includes(lang);
}

export function checkUrlLocale(event: RequestEvent): string {
	const lang = event.params.lang;
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

export function localePath(path: `/${string}`): string {
	return removeTrailingSlash(localPrefix(locale.get()) + path);
}

export function switchLocalePath(lang: string, path: string): string {
	const pathWithoutLocale = path.replace(localPrefix(locale.get()), '');
	return removeTrailingSlash(localPrefix(lang) + pathWithoutLocale || '/');
}

export function localPrefix(lang: string): string {
	return lang === defaultLocale ? '' : `/${lang}`;
}

export function isCurrentLocale(lang: string): boolean {
	return locale.get() === lang;
}

function removeTrailingSlash(str: string): string {
	return str.endsWith('/') && str.length > 1 ? str.slice(0, -1) : str;
}

export const { t, locale, locales, loading, loadTranslations, translations } = new i18n(config);

export function languageFilter<Type extends Translatable>(rows: Type[] | undefined): Type[] {
	return (
		rows?.filter((row) => {
			// By convention language zz means show on all languages
			return row.language == locale.get() || row.language == 'zz';
		}) || []
	);
}

export function languageFind<Type extends Translatable>(
	rows: Type[] | undefined
): Type | undefined {
	return rows?.find((row) => row.language == locale.get());
}
