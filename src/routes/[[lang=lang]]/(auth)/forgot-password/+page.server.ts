import type { Actions } from './$types';
import { api } from '$lib/server/api';

export const actions = {
	default: async (event) => {
		const data = await event.request.formData();
		let response;
		try {
			response = await api({
				method: 'POST',
				path: '/auth/forgot-password',
				data: Object.fromEntries(data),
				event
			});
		} catch (e) {
			return {
				errors: {
					email: 'Something went wrong'
				}
			};
		}
		if (response.ok) {
			return await response.json();
		} else {
			return await response.json();
		}
	}
} satisfies Actions;
