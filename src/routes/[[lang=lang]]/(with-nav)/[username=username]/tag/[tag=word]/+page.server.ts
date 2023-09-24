import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userQuery } from '$lib/server/repositories/gallery';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ parent, params }) => {
	const { user } = await parent();
	return await cacheGet(
		'gallery',
		`${params.username}.${params.tag}`,
		async () => {
			return {
				gallery: await worksPreviewMap(await userQuery(user.id, params.tag, 1))
			}
		}, 5);
}) satisfies PageServerLoad;