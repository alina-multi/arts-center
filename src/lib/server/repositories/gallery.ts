import { PrismaClient } from '@prisma/client';
import type { Prisma } from '@prisma/client';

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});

const PAGE_SIZE = 20;

export function query(
	where: Prisma.worksWhereInput = {},
	orderBy: Prisma.worksOrderByWithRelationInput = {},
	page = 0
) {
	return prisma.works.findMany({
		take: PAGE_SIZE,
		skip: page * PAGE_SIZE,
		select: {
			id: true,
			published_at: true,
			rating: true,
			comments: true,
			hosts: true,
			price: true,
			titles: {
				select: {
					title: true,
					language: true
				}
			},
			image: {
				select: {
					id: true,
					name: true,
					folder: true,
					w300: true,
					w600: true
				}
			},
			owners: {
				select: {
					user: {
						select: {
							id: true,
							username: true,
							name: true,
							avatar: true
						}
					}
				},
				where: {
					ownable_type: 'work'
				}
			}
		},
		where: {
			published_at: { lte: new Date() },
			deleted_at: null,
			...where
		},
		orderBy
	});
}

export function indexQuery(page = 0) {
	return query(
		{
			rating: {
				gte: 20
			}
		},
		{
			published_at: 'desc'
		},
		page
	);
}

export type Gallery = Prisma.PromiseReturnType<typeof query>;
