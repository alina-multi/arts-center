import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/notifications', event });
	const notifications = await response.json();




	return {
		// Flatten structure because it broadcasts flat but in db it's in data
		notifications: notifications.map((notification) => ({
			...notification,
			...notification.data,
			data: undefined
		}))
	};
}) satisfies PageServerLoad;
