import type { PageServerLoad, Actions } from './$types';
import { api } from '$lib/server/api';
import { availableLocales } from '$lib/translations';
import { reloadCurrentUser } from '$lib/server/database/cache';

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
		const errors = {};
		// This is hideous, but I don't know how to do it better
		const data = {
			country: form.get('country'),
			name: form.get('name'),
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
		if (!response.ok) {
			const json = await response.json();
			return {
				data,
				errors: { ...errors, ...json.errors }
			};
		}
		// Invalidate cache to see changes
		await reloadCurrentUser(event);
	}
} satisfies Actions;
