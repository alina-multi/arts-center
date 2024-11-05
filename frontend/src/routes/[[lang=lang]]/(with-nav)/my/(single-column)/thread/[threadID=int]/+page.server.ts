import type { PageServerLoad, Actions } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({
		method: 'GET',
		path: `/api2/thread/${event.params.threadID}`,
		event
	});
	const thread = await response.json();

	return {
		thread
	};
}) satisfies PageServerLoad;

export const actions = {
	default: async (event) => {
		const form = await event.request.formData();
		const errors = { form };
		// This is hideous, but I don't know how to do it better
		const data = {
			message: form.get('message')
		};

		const response = await api({
			method: 'POST',
			path: `/api2/thread/${event.params.threadID}/message`,
			data,
			event
		});
		if (!response.ok) {
			const json = await response.json();
			return {
				data,
				errors: { ...errors, ...json.errors }
			};
		}
	}
} satisfies Actions;
