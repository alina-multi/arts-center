import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';

export const load = (async (event) => {
	const params = { order: 'popular', tag: 'all', page: 1, ...event.params };
	return {
		gallery: await filteredQuery(params.tag, locale.get(), params.order ?? 'popular', 1).then(
			(works) => worksPreviewMap(works)
		),
		params
	};
}) satisfies PageServerLoad;
