import type { Actions, PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const data = await api({ method: 'GET', path: '/api2/notification-preferences', event });
	const preferences = await data.json();

	return preferences;
}) satisfies PageServerLoad;

export const actions: Actions = {
	default: async (event) => {
		const formData = await event.request.formData();

		const preferences = Array.from(formData.keys()).map((key) => {
			const [type, channel] = key.split('_');
			return { type, channel };
		});

		const response = await api({
			method: 'PUT',
			path: '/api2/notification-preferences',
			data: { preferences },
			event
		});

		if (response.ok) {
			return {
				success: true
			};
		}
	}
};
