import type { PageServerLoad } from './$types';
import { query } from '$lib/server/repositories/user';
import { usersMap } from '$lib/server/mappers/users';
import { query as postQuery } from '$lib/server/repositories/post';
import { postsMap } from '$lib/server/mappers/post';
import { newAndRisingIndexQuery, trendingRandomIndexQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';

export const load = (async ({ setHeaders, params }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});

	const [users, posts, trendingWorks, newAndRisingWorks] = await Promise.all([
		query({ verified_at: { not: null } }, { verified_at: 'desc' }).then((usersRaw) =>
			usersMap(usersRaw, params.lang)
		),
		postQuery({ featured: 1, language: params.lang }, { published_at: 'desc' }).then((postsRaw) =>
			postsMap(postsRaw)
		),
		trendingRandomIndexQuery().then((worksRaw) => worksPreviewMap(worksRaw)),
		newAndRisingIndexQuery().then((worksRaw) => worksPreviewMap(worksRaw))
	]);

	return {
		users,
		posts,
		trendingWorks,
		newAndRisingWorks
	};
}) satisfies PageServerLoad;
