import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';

export const load = (async (event) => {
	if (useMockData()) return { followers: [] };
	const response = await api({ method: 'GET', path: '/api2/followers', event });
	const followers = await response.json();

	return {
		followers
	};
}) satisfies PageServerLoad;
