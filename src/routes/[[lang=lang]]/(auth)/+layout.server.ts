import type { LayoutServerLoad } from './$types';
import { checkAuth } from '$lib/server/auth';

export const load = (async (event) => {
	// We want to force SvelteKit to run it all the time
	const path = event.url.pathname;
	return {
		user: await checkAuth(event)
	}
}) satisfies LayoutServerLoad;
