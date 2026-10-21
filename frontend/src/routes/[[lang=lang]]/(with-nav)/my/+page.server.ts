import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import type { PageServerLoad } from './$types';

export const load = (({ params }) => {
	redirect(302, localePath(params.lang, '/my/work'));
}) satisfies PageServerLoad;
