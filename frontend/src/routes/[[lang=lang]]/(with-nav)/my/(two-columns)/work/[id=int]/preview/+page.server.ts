import type { Actions, PageLoad } from './$types';
import { api } from '$lib/server/api';
import { redirect } from '@sveltejs/kit';
import { get } from '$lib/server/repositories/work';
import { workPreviewMap } from '$lib/server/mappers/work';
import { localePath } from '$lib/translations';
import { useMockData } from '$lib/server/mock/mode';
import { publishDemoWork } from '$lib/server/mock/actions';

export const load = (async ({ params }) => {
	const data = {
		work: await get(BigInt(params.id)).then((work) => ({
			...workPreviewMap(work)
		}))
	};
	if (!data?.work?.id || data?.work?.published_at) {
		redirect(302, localePath(params.lang, `/work/${data.work.id}`));
	}
	return data;
}) satisfies PageLoad;

export const actions = {
	default: async (event) => {
		const form = await event.request.formData();
		if (useMockData()) {
			await publishDemoWork(event.params.id, form.get('published_at'));
			redirect(302, localePath(event.params.lang, `/work/${event.params.id}`));
		}
		const response = await api({
			method: 'PUT',
			path: `/api2/work/${event.params.id}/publish`,
			event,
			data: {
				published_at: form.get('published_at')
			}
		});
		if (response.ok) {
			redirect(302, localePath(event.params.lang, `/work/${event.params.id}`));
		}
		return await response.json();
	}
} satisfies Actions;
