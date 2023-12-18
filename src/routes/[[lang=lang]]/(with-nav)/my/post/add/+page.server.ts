import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const load = (async (event) => {
	const response = await api({
		method: 'POST',
		path: '/api2/post',
		event
	});
	const { id } = await response.json();
	throw redirect(301, localePath(`/my/post/edit/${id}`));
}) satisfies PageServerLoad;
