import type { PageServerLoad } from './$types';
import { error } from '@sveltejs/kit';
import { userAllPostsQuery } from '$lib/server/repositories/post';
import { postsMap } from '$lib/server/mappers/post';

export const load = (async ({ parent }) => {
	const { user } = await parent();
	if (!user?.id) {
		throw error(404);
	}
	const posts = postsMap(await userAllPostsQuery(user.id));
	return {
		posts
	};
}) satisfies PageServerLoad;
