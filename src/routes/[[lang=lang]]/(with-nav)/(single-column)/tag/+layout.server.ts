import type { LayoutServerLoad } from './$types';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async () => {
	return {
		categories: await getCategories().then((categories) => tagsMap(categories))
	};
}) satisfies LayoutServerLoad;
