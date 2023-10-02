import type { PageServerLoad, Actions } from './$types';
import { api } from '$lib/server/api';
import { error, redirect } from '@sveltejs/kit';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { localePath } from '$lib/translations';

export const load = (async (event) => {
	const [data, categories] = await Promise.all([
		api({
			method: 'GET',
			path: `/api2/draft/${event.params.id}`,
			event
		}).then(async (response) => response.json()),
		getCategories().then((categories) => tagsMap(categories))
	]);

	if (!data.id || data.deleted_at) {
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
		let crop = form.get('crop');
		crop = crop ? JSON.parse(crop as string) : undefined;
		const response = await api({
			method: 'PUT',
			path: `/api2/draft/${event.params.id}`,
			event,
			data: {
				language: event.params.lang,
				title: form.get('title'),
				description: form.get('description'),
				category: form.get('category')?.split(','),
				crop
			}
		});
		if (response.ok) {
			throw redirect(302, localePath(`/my/work/preview/${event.params.id}`));
		}
		return await response.json();
	},
	delete: async (event) => {
		const response = await api({
			method: 'DELETE',
			path: `/api2/draft/${event.params.id}`,
			event
		});
		if (response.ok) {
			throw redirect(302, localePath(`/my/work/draft`));
		}
		return await response.json();
	}
} satisfies Actions;
