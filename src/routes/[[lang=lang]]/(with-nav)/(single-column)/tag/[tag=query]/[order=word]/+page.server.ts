import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';
import { cacheGet } from '$lib/server/database/cache';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async ({ params, setHeaders, url }) => {
	setHeaders({
		'cache-control': 'max-age=6000'
	});
	const lang = locale.get() ?? 'en';
	params.order ??= 'popular';
	params.tag ??= 'all';
	params.page ??= 1;

	const key = `${params.tag}.${lang}.${params.order}.1`;
	// This is here just to let SvelteKit know to invalidate the page when the pathname changes
	url.pathname;
	return await cacheGet(
		'gallery',
		key,
		async () => {
			return {
				categories: await getCategories().then((categories) => tagsMap(categories)),
				gallery: await filteredQuery(params.tag, lang, params.order, 1).then((works) =>
					worksPreviewMap(works)
				),
				params
			};
		},
		params.order === 'new' ? 5 : 60 * 60 // New updates often
	);
}) satisfies PageServerLoad;
