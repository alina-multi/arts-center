import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/follow', event });
	const following = await response.json();

	return {
		users:following.users
	};
}) satisfies PageServerLoad;