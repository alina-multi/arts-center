import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userQuery } from '$lib/server/repositories/gallery';
import { cacheGet } from '$lib/server/database/cache';
import { locale } from '$lib/translations';

export const load = (async ({ parent, params }) => {
	const { user } = await parent();
	const lang= locale.get();
	return await cacheGet(
		'gallery',
		`${params.username}.${lang}`,
		async () => {
			return {
				gallery: await worksPreviewMap(await userQuery(user.id, 'all', lang, 1))
			};
		},
		5
	);
}) satisfies PageServerLoad;
