import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({
		method: 'GET',
		path: `/api2/thread/${event.params.threadID}`,
		event
	});
	const thread = await response.json();

	return {
		thread
	};
}) satisfies PageServerLoad;
