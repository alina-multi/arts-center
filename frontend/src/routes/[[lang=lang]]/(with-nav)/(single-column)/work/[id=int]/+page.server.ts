import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/work';
import { workMap } from '$lib/server/mappers/work';
import { get as getComments } from '$lib/server/repositories/comment';
import { commentsMap } from '$lib/server/mappers/comments';
import { error } from '@sveltejs/kit';
import { getOwnerWorks } from '$lib/server/repositories/owner';

export const load = (async ({ params }) => {
	const [work, comments] = await Promise.all([
		get(BigInt(params.id)).then((work) => workMap(work, params.lang)),
		getComments(BigInt(params.id), 'work').then((comments) => commentsMap(comments))
	]);

	if (!work || work.status < 10) {
		error(404);
	}

	const ownerWorks = await Promise.all(
		work.owners.map(async (owner) => ({
			...owner,
			last_works: await getOwnerWorks(owner.id, work.id)
		}))
	);

	return {
		work: {
			...work,
			owners: ownerWorks
		},
		comments
	};
}) satisfies PageServerLoad;
