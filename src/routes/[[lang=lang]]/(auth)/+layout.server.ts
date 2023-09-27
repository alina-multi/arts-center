import type { LayoutServerLoad } from './$types';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const load = (async (event) => {
	// We shouldn't be able to access any of the pages here if we already authorized
	if (event.locals?.user) {
		if (!event.url.pathname.includes('logout')) {
			throw redirect(302, localePath('/'));
		}
	}
}) satisfies LayoutServerLoad;
