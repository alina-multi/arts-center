import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async ({ params, setHeaders, url }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	params.order ??= 'popular';
	params.tag ??= 'all';
	params.page ??= 1;

	// This is here just to let SvelteKit know to invalidate the page when the pathname changes
	url.pathname;
	return {
		categories: tagsMap(await getCategories(), params.lang),
		gallery: worksPreviewMap(await filteredQuery(params.tag, params.lang, params.order, 1)),
		params
	};
}) satisfies PageServerLoad;
