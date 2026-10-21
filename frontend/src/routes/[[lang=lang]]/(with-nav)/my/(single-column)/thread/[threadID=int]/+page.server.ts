import type { PageServerLoad, Actions } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { addDemoMessage, getDemoThread } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) return { thread: getDemoThread(event.params.threadID) };
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

		if (useMockData()) {
			await addDemoMessage(event.params.threadID, data.message);
			return { success: true };
		}
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

		if (response.ok) {
			return { success: true };
		}
	}
} satisfies Actions;
