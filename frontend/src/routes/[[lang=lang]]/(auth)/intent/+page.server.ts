import type { Actions, PageServerLoad } from './$types';
import { localePath } from '$lib/translations';
import { api, csrf } from '$lib/server/api';

export const load = (async (event) => {
	await csrf(event);
	return {};
}) satisfies PageServerLoad;

export const actions = {
	default: async (event) => {
		const data = await event.request.formData();
		const intent = data.get('intent');

		if (!intent) {
			return {
				errors: {
					intent: 'Please select an intent'
				}
			};
		}

		let response;

		try {
			response = await api({
				method: 'PUT',
				path: '/api2/intent',
				data: { intent },
				event
			});

			if (response.ok) {
				const redirectUrl =
					event.url.searchParams.get('redirect') ||
					localePath((event.params.lang as 'en' | 'uk') || 'en', '/');
				return {
					status: 303,
					redirect: redirectUrl
				};
			} else {
				return {
					...(await response.json())
				};
			}
		} catch (e) {
			return {
				errors: {
					intent: 'Something went wrong'
				}
			};
		}
	}
} satisfies Actions;
