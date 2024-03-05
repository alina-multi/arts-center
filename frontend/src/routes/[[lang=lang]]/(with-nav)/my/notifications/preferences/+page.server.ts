import type { Actions, PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/notification-preferences', event });
	const preferences = await response.json();

	return preferences;
}) satisfies PageServerLoad;

export const actions: Actions = {
	default: async ({ request }) => {
		const formData = await request.formData();

		const preferences = [];

		for (const entry of formData) {
			const [type, channel] = entry[0].split('_');
			if (entry[1] === 'on') {
				preferences.push({ type: parseInt(type, 10), channel: parseInt(channel, 10) });
			}
		}

		console.log('Saved preferences:', preferences);

		return {
			preferences,
			success: true,
			message: 'Preferences updated successfully.'
		};
	}
};
