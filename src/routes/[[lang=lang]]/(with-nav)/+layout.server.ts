import type { LayoutServerLoad } from './$types';

export const load = (async ({locals, url}) => {
	return {
		currentUser: locals?.user
	};
}) satisfies LayoutServerLoad;
