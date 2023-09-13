import type { LayoutServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	console.log('favorites layout load', event.params);
	const folder_id = Number(event.params.folder_id);

	if (folder_id === 0) {
		return { folders: [] };
	}

	const response = await api({ method: 'GET', path: '/api2/favorite-folder', event });
	const folders = await response.json();

	return {
		folders,
		params: event.params
	};
}) satisfies LayoutServerLoad;
