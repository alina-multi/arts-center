import type { PageServerLoad, Actions, PageLoad } from './$types';
import { api } from '$lib/server/api';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { error, redirect } from '@sveltejs/kit';
import { languageFilter, locale, localePath } from '$lib/translations';
export const load = (async (event) => {
	const [data, categories] = await Promise.all([
		api({
			method: 'GET',
			path: `/api2/draft/${event.params.id}`,
			event
		}).then(async (response) => await response.json()),
		getCategories().then((categories) => tagsMap(categories))
	]);
	// Check that you are the owner
	if (!data.owners.filter(({ id }) => id === event.locals.user.id)?.length) {
		throw error(404, 'Not found');
	}
	data.titles = languageFilter(data.titles);
	if (!data.id || !data.published_at) {
		throw error(404, 'Not found');
	}
	return {
		...data,
		categories
	};
}) satisfies PageServerLoad;



export const actions = {
	post: async (event) => {
				const form = await event.request.formData();
				const response = await api({
					method: 'PUT',
					path: `/api2/draft/${event.params.id}`,
					event,
					data: {
						language: locale.get(),
						title: form.get('title'),
						description: form.get('description'),
						category: form.get('category')?.split(',')
					}
				});
				if (response.ok) {
					throw redirect(302, localePath(`/work/${event.params.id}`));
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
			throw redirect(302, localePath(`/my/work/draft`));
		}
		return await response.json();
	}
};

