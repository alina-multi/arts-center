import type { PageServerLoad, Actions } from './$types';
import { api } from '$lib/server/api';
import { availableLocales } from '$lib/translations';

export const load = (async (event) => {
	return {
		profile: await api({
			method: 'GET',
			path: '/api2/profile',
			event
		}).then(async (response) => await response.json())
	};
}) satisfies PageServerLoad;

export const actions = {
	default: async (event) => {
		const form = await event.request.formData();
		// This is hideous, but I don't know how to do it better

		const data = {
			country: form.get('country'),
			name: form.get('name'),
			username: form.get('username'),
			email: form.get('email'),
			password: form.get('password') || undefined,
			password_confirmation: form.get('password_confirmation') || undefined,
			current_password: form.get('current_password') || undefined,
			// Creates bios[lang]=text
			bios: Object.fromEntries(
				availableLocales.map((locale: string) => [locale, form.get(`bios[${locale}]`)])
			)
		};
		const response = await api({ method: 'PUT', path: '/api2/profile', data, event });
		if (response.status === 422) {
			const json = await response.json();
			return {
				errors: json.errors
			};
		}
	}
} satisfies Actions;
