import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/work';
import { workMap } from '$lib/server/mappers/work';
import { get as getComments } from '$lib/server/repositories/comment';
import { commentsMap } from '$lib/server/mappers/comments';
import { error } from '@sveltejs/kit';

export const load = (async ({ params, setHeaders }) => {
	const [work, comments] = await Promise.all([
		get(BigInt(params.id)).then((work) => workMap(work)),
		getComments(BigInt(params.id), 'work').then((comments) => commentsMap(comments))
	]);
	if (!work.published_at) {
		throw error(404);
	}
	return {
		work,
		comments
	};
}) satisfies PageServerLoad;
