import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/blacklist', event });
	const blacklist = await response.json();

	return {
		blacklist
	};
}) satisfies PageServerLoad;