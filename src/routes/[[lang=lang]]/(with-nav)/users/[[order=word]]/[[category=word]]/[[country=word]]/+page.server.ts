import { usersMap } from '$lib/server/mappers/users';
import { query } from '$lib/server/repositories/user';
import type { PageServerLoad } from './$types';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';

export const load = (async ({ params }) => {
	return {
		users: await usersMap(await query()),
		categories: await getCategories().then((categories) => tagsMap(categories)),
		params: {
			order: params.order || 'popular',
			category: params.category || 'all',
			country: params.country || 'all'
		}
	};
}) satisfies PageServerLoad;
