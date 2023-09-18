import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';

export const load = (async ({params, setHeaders}) => {
	setHeaders({
		"cache-control": "max-age=6000",
	});
	params = { order: 'popular', tag: 'all', page: 1, ...params };
	return {
		gallery: await filteredQuery(params.tag, locale.get(), params.order ?? 'popular', 1).then(
			(works) => worksPreviewMap(works)
		),
		params
	};
}) satisfies PageServerLoad;
