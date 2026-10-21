import type { LayoutServerLoad } from './$types';
import { checkAuth } from '$lib/server/auth';
import { useMockData } from '$lib/server/mock/mode';

export const load = (async (event) => {
	return {
		user: await checkAuth(event),
		demo: useMockData()
	};
}) satisfies LayoutServerLoad;
