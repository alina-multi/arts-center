import type { LayoutServerLoad } from './$types';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async ({ params }) => {
	params.lang;
	return {
		categories: await getCategories().then((categories) => tagsMap(categories))
	};
}) satisfies LayoutServerLoad;
