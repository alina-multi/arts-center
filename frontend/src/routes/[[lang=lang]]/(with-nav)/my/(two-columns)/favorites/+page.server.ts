import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { demoFolders } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) return { folders: demoFolders() };
	const response = await api({ method: 'GET', path: '/api2/favorite-folder', event });
	const folders = await response.json();

	return {
		folders
	};
}) satisfies PageServerLoad;
