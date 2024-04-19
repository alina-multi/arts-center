import type { Actions, PageServerLoad } from './$types';
import { api, csrf } from '$lib/server/api';
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
				path: '/auth/login',
				data: Object.fromEntries(data),
				event
			});
		} catch (e) {
			return {
				email: data.get('email'),
				errors: {
					email: 'Something went wrong'
				}
			};
		}
		if (response.ok) {
			redirect(
            				301,
            				event.url.searchParams.get('redirect') || localePath(event.params.lang, '/')
            			);
		} else {
			return {
				...(await response.json()),
				email: data.get('email')
			};
		}
	}
} satisfies Actions;

export const load = (async (event) => {
	await redirectIfAuthorized(event);
	await csrf(event);
	return {};
}) satisfies PageServerLoad;
