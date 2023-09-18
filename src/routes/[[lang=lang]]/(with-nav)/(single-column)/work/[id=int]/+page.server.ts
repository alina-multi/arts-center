import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/work';
import { workMap } from '$lib/server/mappers/work';
import { get as getComments } from '$lib/server/repositories/comment';
import { commentsMap } from '$lib/server/mappers/comments';
import { error } from '@sveltejs/kit';
import { cacheGet } from '$lib/server/database/cache';
export const load = (async ({ params, setHeaders }) => {
	setHeaders({
		"cache-control": "max-age=600",
	});
	return cacheGet(
		`frontend.work.${params.id}`,
		async () => {
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
		},
		5
	)
}) satisfies PageServerLoad;
