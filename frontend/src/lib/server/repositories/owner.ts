import { prisma } from '$lib/server/database/prisma';
import { gallerySelect } from './gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { useMockData } from '$lib/server/mock/mode';
import { mockOwnerWorks } from '$lib/server/mock/read';

export async function getOwnerWorks(ownerId: bigint, excludeWorkId: bigint) {
	if (useMockData()) {
		return worksPreviewMap(mockOwnerWorks(ownerId, excludeWorkId));
	}
	const works = await prisma.works.findMany({
		where: {
			owners: {
				some: {
					user_id: ownerId
				}
			},
			id: {
				not: excludeWorkId
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

	return worksPreviewMap(works);
}
