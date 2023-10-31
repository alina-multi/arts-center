import type { PageServerLoad } from './$types';
import { query } from '$lib/server/repositories/user';
import { usersMap } from '$lib/server/mappers/users';
import { latest } from '$lib/server/repositories/comment';
import { lastCommentsMap } from '$lib/server/mappers/comments';

export const load = (async ({ setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=60'
	});
	const users = await query(
		{
			verified_at: { not: null }
		},
		{
			verified_at: 'desc'
		}
	);

	const comments = await latest();

	return {
		users: await usersMap(users),
		comments: await lastCommentsMap(comments)
	};
}) satisfies PageServerLoad;
