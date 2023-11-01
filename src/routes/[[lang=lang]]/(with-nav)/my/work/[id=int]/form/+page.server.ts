import type { Actions } from './$types';
import { api } from '$lib/server/api';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import { formToObject } from '$lib/helpers/form';

export const actions = {
	post: async (event) => {
		const form = await event.request.formData();
		const data = formToObject(form);
		data.category = data.category.split(',');

		const response = await api({
			method: 'PUT',
			path: `/api2/work/${event.params.id}`,
			event,
			data
		});
		if (response.ok) {
			throw redirect(302, localePath(`/my/work/${event.params.id}/preview`));
		}
		return {
			...(await response.json()),
			work: data
		};
	}
} satisfies Actions;
