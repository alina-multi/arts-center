import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/post';
import { error } from '@sveltejs/kit';
import { postMap } from '$lib/server/mappers/post';
import { get as getComments } from '$lib/server/repositories/comment';
import { commentsMap } from '$lib/server/mappers/comments';

export const load = (async ({ params }) => {
	const [post, comments] = await Promise.all([
		get(params.id, {
			published_at: { lte: new Date() }
		}).then((postRaw) => postMap(postRaw)),
		getComments(BigInt(params.id), 'post').then((comments) => commentsMap(comments))
	]);
	if (!post || post?.language != params.lang) {
		error(404);
	}
	return {
		post,
		comments
	};
}) satisfies PageServerLoad;
