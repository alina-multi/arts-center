import type { Actions, PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { error, redirect } from '@sveltejs/kit';
import { languageFilter, localePath } from '$lib/translations';

export const load = (async (event) => {
	const data = await api({
		method: 'GET',
		path: `/api2/draft/${event.params.id}`,
		event
	}).then(async (response) => await response.json());

	const { user } = await event.parent();
	// Check that you are the owner
	if (!data.owners.filter(({ id }) => id === user.id)?.length) {
		error(404, 'Not found');
	}
	data.titles = languageFilter(data.titles, event.params.lang);
	if (!data.id || !data.published_at) {
		error(404, 'Not found');
	}
	return data;
}) satisfies PageServerLoad;

export const actions = {
	post: async (event) => {
		const form = await event.request.formData();
		const response = await api({
			method: 'PUT',
			path: `/api2/draft/${event.params.id}`,
			event,
			data: {
				language: event.params.lang,
				title: form.get('title'),
				description: form.get('description'),
				category: form.get('category')?.split(',')
			}
		});
		if (response.ok) {
			redirect(302, localePath(event.params.lang, `/work/${event.params.id}`));
		}
		return await response.json();
	},
	todrafts: async (event) => {
		const response = await api({
			method: 'DELETE',
			path: `/api2/draft/${event.params.id}/draft`,
			event
		});
		if (response.ok) {
			redirect(302, localePath(event.params.lang, `/my/work/draft`));
		}
		return await response.json();
	}
} satisfies Actions;
