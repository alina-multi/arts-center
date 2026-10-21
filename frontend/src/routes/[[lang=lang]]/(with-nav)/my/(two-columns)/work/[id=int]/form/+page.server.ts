import type { Actions } from './$types';
import { api } from '$lib/server/api';
import { formToObject } from '$lib/helpers/form';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import { useMockData } from '$lib/server/mock/mode';
import { saveDemoWorkDetails } from '$lib/server/mock/actions';

export const actions = {
	post: async (event) => {
		const form = await event.request.formData();
		const data = formToObject(form);
		data.category = data.category.split(',');

		const isPublished = form.get('isPublished') === 'true';

		if (useMockData()) {
			const saved = await saveDemoWorkDetails(event.params.id, data);
			if (!isPublished) {
				redirect(302, localePath(event.params.lang, `/my/work/${event.params.id}/preview`));
			}
			return { success: true, work: saved.work, message: saved.message };
		}
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
