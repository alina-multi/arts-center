import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userQuery } from '$lib/server/repositories/gallery';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ parent, params }) => {
	const { user } = await parent();
	return await cacheGet(
		'gallery',
		`${params.username}.${params.lang}`,
		async () => {
			return {
				params,
				user,
				gallery: await worksPreviewMap(await userQuery(user.id, 'all', params.lang, 1))
			};
		},
		5
	);
}) satisfies PageServerLoad;
