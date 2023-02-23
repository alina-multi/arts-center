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

export function get(id: bigint) {
	return prisma.works.findUnique({
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
			},
			details: {
				select: {
					year: true,
					width: true,
					height: true,
					length: true
				}
			},
			blocks: {
				select: {
					id: true,
					language: true,
					type: true,
					order: true,
					data: true
				},
				orderBy: {
					order: 'asc'
				}
			}
		},
		where: {
			id
		}
	});
}
