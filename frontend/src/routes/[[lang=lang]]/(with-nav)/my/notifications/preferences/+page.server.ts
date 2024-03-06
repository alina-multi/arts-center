import type { Actions, PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { createFullPreferencesData } from '$lib/helpers/createNotifPreferData';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/notification-preferences', event });
	const preferences = await response.json();

	return preferences;
}) satisfies PageServerLoad;

export const actions: Actions = {
	default: async ({ request }) => {
		const formData = await request.formData();
		let allPreferences = createFullPreferencesData();

		for (const [channel, type] of formData) {
			allPreferences = allPreferences.filter(
				(pref) => !(pref.type === Number(type) && pref.channel === Number(channel))
			);
		}

		// At this point, allPreferences contains only those preferences that were not 'on' (thus, they are unchecked).
		console.log('Remaining unchecked preferences:', allPreferences);

		return {
			allPreferences,
			success: true,
			message: 'Preferences updated successfully.'
		};
	}
};
