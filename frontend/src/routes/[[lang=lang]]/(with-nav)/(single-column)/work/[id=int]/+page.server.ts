import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/work';
import { workMap } from '$lib/server/mappers/work';
import { get as getComments } from '$lib/server/repositories/comment';
import { commentsMap } from '$lib/server/mappers/comments';
import { error } from '@sveltejs/kit';
import { getOwnerWorks } from '$lib/server/repositories/owner';

export const load = (async ({ params }) => {
	const [raw, comments] = await Promise.all([
		get(BigInt(params.id)),
		getComments(BigInt(params.id), 'work').then((comments) => commentsMap(comments))
	]);

	if (!raw || raw.status < 10) {
		error(404);
	}

	const work = workMap(raw, params.lang);

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
