import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({
		method: 'GET',
		path: `/api2/checkout/${event.url.searchParams.get('session_id')}`,
		event
	});
	return await response.json();
}) satisfies PageServerLoad;
