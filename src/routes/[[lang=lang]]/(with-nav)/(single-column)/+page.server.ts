import type { PageServerLoad } from './$types';
import { indexQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=6000'
	});

	return cacheGet(
		'frontend.index',
		async () => {
			const [gallery, categories] = await Promise.all([
				indexQuery().then((works) => worksPreviewMap(works)),
				getCategories().then((categories) => tagsMap(categories))
			]);

			return {
				gallery,
				categories,
				params: { order: 'popular', tag: 'all', page: 1 }
			};
		},
		60 * 60
	);
}) satisfies PageServerLoad;
