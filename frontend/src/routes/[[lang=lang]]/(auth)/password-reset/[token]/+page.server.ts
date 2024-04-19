import type { Actions, PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import { redirectIfAuthorized } from '$lib/server/auth';

export const actions = {
	default: async (event) => {
		const data = await event.request.formData();
		let response;
		try {
			response = await api({
				method: 'POST',
				path: '/auth/reset-password',
				data: {
					...Object.fromEntries(data),
					email: event.url.searchParams.get('email'),
					token: event.params.token
				},
				event
			});
		} catch (e) {
			return {
				errors: {
					password: 'Something went wrong'
				}
			};
		}
		if (response.ok) {
			redirect(301, localePath(event.params.lang, '/login'));
		} else {
			return await response.json();
		}
	}
} satisfies Actions;

export const load = (async (event) => {
	await redirectIfAuthorized(event);
}) satisfies PageServerLoad;
