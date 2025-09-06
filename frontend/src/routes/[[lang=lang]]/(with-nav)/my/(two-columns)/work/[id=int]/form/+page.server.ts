import type { Actions } from './$types';
import { api } from '$lib/server/api';
import { formToObject } from '$lib/helpers/form';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const actions = {
	post: async (event) => {
		const form = await event.request.formData();
		const data = formToObject(form);
		data.category = data.category.split(',');

		const isPublished = form.get('isPublished') === 'true';

		const response = await api({
			method: 'PUT',
			path: `/api2/work/${event.params.id}`,
			event,
			data
		});

		const responseData = await response.json();

		if (response.ok) {
			if (!isPublished) {
				redirect(302, localePath(event.params.lang, `/my/work/${event.params.id}/preview`));
			}

			const result = {
				success: true,
				work: responseData,
				message: responseData.message || 'Збережено успішно'
			};

			return result;
		} else {
			const result = {
				success: false,
				errors: responseData.errors,
				message: responseData.message
			};

			return result;
		}
	}
} satisfies Actions;
