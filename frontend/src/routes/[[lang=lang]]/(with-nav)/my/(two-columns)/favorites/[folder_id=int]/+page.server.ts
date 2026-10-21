import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { demoFolder } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) return { favorites: demoFolder(event.params.folder_id) };
	const response = await api({
		method: 'GET',
		path: `/api2/favorite-folder/${event.params.folder_id}`,
		event
	});
	const favorites = await response.json();

	return {
		favorites
	};
}) satisfies PageServerLoad;
