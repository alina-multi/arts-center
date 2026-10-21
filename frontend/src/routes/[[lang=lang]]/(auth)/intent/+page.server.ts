import type { Actions, PageServerLoad } from './$types';
import { localePath } from '$lib/translations';
import { api, csrf } from '$lib/server/api';
import { redirect } from '@sveltejs/kit';
import { useMockData } from '$lib/server/mock/mode';
import { saveDemoIntent } from '$lib/server/mock/actions';

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

		if (useMockData()) {
			await saveDemoIntent(String(intent));
			throw redirect(
				303,
				event.url.searchParams.get('redirect') ||
					localePath((event.params.lang as 'en' | 'uk') || 'en', '/')
			);
		}

		let response;

		try {
			response = await api({
				method: 'PUT',
				path: '/api2/intent',
				data: { intent },
				event
			});
		} catch (e) {
			return {
				errors: {
					intent: 'Something went wrong'
				}
			};
		}

		if (response.ok) {
			const redirectUrl =
				event.url.searchParams.get('redirect') ||
				localePath((event.params.lang as 'en' | 'uk') || 'en', '/');
			throw redirect(303, redirectUrl);
		}

		return {
			...(await response.json())
		};
	}
} satisfies Actions;
