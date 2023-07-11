import type { LayoutServerLoad } from './$types';

export const load = (async (event) => {
	return {
		currentUser: event.locals?.user
	};
}) satisfies LayoutServerLoad;
