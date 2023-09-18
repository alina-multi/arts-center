import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ params, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=6000'
	});
	params = { order: 'popular', tag: 'all', page: 1, ...params };
	const cacheKey = `frontend.tag.${params.tag}.${locale.get()}.${params.order}.1`;
	return cacheGet(
		cacheKey,
		async () => {
			return {
				gallery: await filteredQuery(params.tag, locale.get(), params.order, 1).then(
					(works) => worksPreviewMap(works)
				),
				params
			};
		},
		params.order === 'new' ? 5 : 60 * 60 // New updates often
	);

}) satisfies PageServerLoad;
