import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/work';
import { workMap } from '$lib/server/mappers/work';
import { get as getComments } from '$lib/server/repositories/comment';
import { commentsMap } from '$lib/server/mappers/comments';
import { error } from '@sveltejs/kit';
import { prisma } from '$lib/server/database/prisma';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { gallerySelect } from '$lib/server/repositories/gallery';

export const load = (async ({ params }) => {
	const [work, comments] = await Promise.all([
		get(BigInt(params.id)).then((work) => workMap(work, params.lang)),
		getComments(BigInt(params.id), 'work').then((comments) => commentsMap(comments))
	]);

	if (!work || work.status < 10) {
		error(404);
	}


	const ownerWorks = await Promise.all(
		work.owners.map(async (owner) => {
			const works = await prisma.works.findMany({
				where: {
					owners: {
						some: {
							user_id: owner.id
						}
					},
					id: {
						not: work.id // Exclude current work
					},
					status: {
						gte: 40 // Only published works 
					}
				},
				orderBy: {
					published_at: 'desc'
				},
				take: 6,
				select: gallerySelect
			});

			return {
				...owner,
				last_works: worksPreviewMap(works)
			};
		})
	);

	return {
		work: {
			...work,
			owners: ownerWorks
		},
		comments
	};
}) satisfies PageServerLoad;
