import type { Actions } from './$types';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';

export const actions = {
	default: async (event) => {
		const data = await event.request.formData();

		let response;

		try {
			console.log(data.get('intent'));
			response = { ok: true };
		} catch (e) {
			return {
				errors: {
					email: 'Something went wrong'
				}
			};
		}
		if (response.ok) {
			redirect(
				301,
				event.url.searchParams.get('redirect') || localePath(event.params.lang, '/my/profile')
			);
		} else {
			return {
				...(await response.json())
			};
		}
	}
} satisfies Actions;
