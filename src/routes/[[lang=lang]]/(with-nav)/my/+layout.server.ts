import type { LayoutServerLoad } from './$types';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const load = (async (event) => {
	if (!event.locals?.user) {
		throw redirect(301, localePath('/login?redirect=' + event.url.pathname));
	}
}) satisfies LayoutServerLoad;
