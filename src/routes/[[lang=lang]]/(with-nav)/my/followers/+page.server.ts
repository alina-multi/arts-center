import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/followers', event });
	const followers = await response.json();

	return {
		followers
	};
}) satisfies PageServerLoad;
