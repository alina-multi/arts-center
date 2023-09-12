import type { PageServerLoad } from './$types';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	await api({ method: 'POST', path: '/auth/logout', event });
	event.cookies.delete('laravel_token');
	event.locals.user = undefined;
	throw redirect(302, event.url.searchParams.get('redirect') || localePath('/'));
}) satisfies PageServerLoad;
