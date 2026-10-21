import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { error, redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import { useMockData } from '$lib/server/mock/mode';
import { createDemoPost } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) {
		const { id } = await createDemoPost();
		redirect(303, localePath(event.params.lang, `/my/post/edit/${id}`));
	}
	const response = await api({
		method: 'POST',
		path: '/api2/post',
		event
	});
	const { id } = await response.json();
	if (!id) {
		error(500, 'Could not create post');
	}
	redirect(301, localePath(event.params.lang, `/my/post/edit/${id}`));
}) satisfies PageServerLoad;
