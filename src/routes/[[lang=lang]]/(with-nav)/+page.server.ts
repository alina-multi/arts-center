import type { PageServerLoad } from './$types';
import { indexQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async ({ params }) => {
	return Promise.all([
		indexQuery().then((works) => worksPreviewMap(works)),
		getCategories().then((categories) => tagsMap(categories))
	]).then((values) => {
		return {
			gallery: values[0],
			categories: values[1]
		};
	});
}) satisfies PageServerLoad;
