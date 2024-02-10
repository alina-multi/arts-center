import type { LayoutServerLoad } from './$types';
import { checkAuth } from '$lib/server/auth';

export const load = (async (event) => {
	return {
		user: await checkAuth(event)
	};
}) satisfies LayoutServerLoad;
