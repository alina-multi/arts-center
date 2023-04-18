import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';

export const load = (async ({ params }) => {
	return Promise.all([
		filteredQuery(params.tag, locale.get(), params.order ?? 'popular').then((works) =>
			worksPreviewMap(works)
		),
		getCategories().then((categories) => tagsMap(categories))
	]).then((values) => {
		return {
			gallery: values[0],
			categories: values[1],
			params: { order: 'popular', tag: 'all', ...params }
		};
	});
}) satisfies PageServerLoad;
