import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { demoBlocked } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) return { blacklist: demoBlocked(event.params.lang) };
	const response = await api({ method: 'GET', path: '/api2/blacklist', event });
	const blacklist = await response.json();

	return {
		blacklist
	};
}) satisfies PageServerLoad;
