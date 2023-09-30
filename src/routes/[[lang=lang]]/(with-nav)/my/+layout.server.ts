import type { LayoutServerLoad } from './$types';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import { checkAuth } from '$lib/server/auth';

export const load = (async (event) => {
	const user = await checkAuth(event);
	if (!user?.id) {
		throw redirect(301, localePath('/login?redirect=' + event.url.pathname));
	}
	return { user };
}) satisfies LayoutServerLoad;
