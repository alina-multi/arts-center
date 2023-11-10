import type { PageServerLoad } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userQuery } from '$lib/server/repositories/gallery';

export const load = (async ({ parent, params }) => {
	const { user } = await parent();
	return {
		params,
		user,
		gallery: await worksPreviewMap(await userQuery(user.id, 'all', params.lang, 1))
	};
}) satisfies PageServerLoad;
