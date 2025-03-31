import { prisma } from '$lib/server/database/prisma';
import { gallerySelect } from './gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';

export async function getOwnerWorks(ownerId: bigint, excludeWorkId: bigint) {
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