import { userDraftQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import type { PageServerLoad } from './$types';
import { error } from '@sveltejs/kit';

export const load = (async ({ parent }) => {
	const { user } = await parent();
	if (!user?.id) {
		throw error(404);
	}
	const gallery = await worksPreviewMap(await userDraftQuery(user.id));
	return {
		gallery
	};
}) satisfies PageServerLoad;
