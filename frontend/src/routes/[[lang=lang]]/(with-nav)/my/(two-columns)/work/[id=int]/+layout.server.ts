import type { LayoutServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	event.params.lang;
	const response = await api({
		method: 'GET',
		path: `/api2/work/${event.params.id}`,
		event
	});
	return {
		work: await response.json()
	};
}) satisfies LayoutServerLoad;
