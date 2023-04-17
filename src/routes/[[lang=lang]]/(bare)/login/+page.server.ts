import type { Actions, PageServerLoad } from './$types';
import { api, csrf } from '$lib/server/api';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const actions = {
	default: async (event) => {
		const data = await event.request.formData();
		const response = await api({
			method: 'POST',
			path: '/auth/login',
			data: Object.fromEntries(data),
			event
		});
		if (response.status === 422) {
			return await response.json();
		} else if (response.ok) {
			throw redirect(301, event.url.searchParams.get('redirect') ?? localePath('/'));
		}
	}
} satisfies Actions;

export const load = (async (event) => {
	await csrf(event);
}) satisfies PageServerLoad;
