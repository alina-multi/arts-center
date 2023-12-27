import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { error, redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const load = (async (event) => {
	const response = await api({
		method: 'POST',
		path: '/api2/post',
		event
	});
	const { id } = await response.json();
	if (!id) {
		throw error(500, 'Could not create post');
	}
	throw redirect(301, localePath(event.params.lang, `/my/post/edit/${id}`));
}) satisfies PageServerLoad;
