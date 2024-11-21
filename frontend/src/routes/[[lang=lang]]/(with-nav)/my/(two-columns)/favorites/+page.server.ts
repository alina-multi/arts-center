import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/favorite-folder', event });
	const folders = await response.json();

	return {
		folders
	};
}) satisfies PageServerLoad;
