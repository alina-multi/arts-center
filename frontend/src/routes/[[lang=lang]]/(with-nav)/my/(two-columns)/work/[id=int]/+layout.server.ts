import type { LayoutServerLoad } from './$types';
import { error } from '@sveltejs/kit';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { get } from '$lib/server/repositories/work';
import { pictureMap } from '$lib/server/mappers/pictures';

export const load = (async (event) => {
	event.params.lang;
	if (useMockData()) {
		const work = await get(BigInt(event.params.id));
		if (!work) error(404, 'Work not found');
		return {
			work: {
				id: Number(work.id),
				published_at: work.published_at,
				status: work.status,
				titles: work.titles,
				category: work.tags?.[0]?.tag?.id?.toString(),
				full: pictureMap(work.full),
				preview: pictureMap(work.preview),
				images: work.images.flatMap(({ image }) => {
					const photo = pictureMap(image);
					if (!photo?.src) return [];
					return [{ id: Number(image.id), ...photo }];
				})
			}
		};
	}
	const response = await api({
		method: 'GET',
		path: `/api2/work/${event.params.id}`,
		event
	});
	return {
		work: await response.json()
	};
}) satisfies LayoutServerLoad;
