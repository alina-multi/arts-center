import type { Prisma } from '@prisma/client';
import { PrismaClient } from '@prisma/client';

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
	where: Prisma.usersWhereInput = {},
	orderBy: Prisma.usersOrderByWithRelationInput = {},
	page = 0
) {
	return prisma.users.findMany({
		take: PAGE_SIZE,
		skip: page * PAGE_SIZE,
		select: {
			id: true,
			username: true,
			name: true,
			avatar: true,
			country: true,
			created_at: true
		},
		where,
		orderBy
	});
}

export function get(username: string) {
	return prisma.users.findUnique({
		select: {
			id: true,
			username: true,
			name: true,
			avatar: true,
			country: true,
			created_at: true,
			ratings: {
				select: {
					rating: true,
					language: true,
					tag: {
						select: {
							id: true,
							titles: {
								select: {
									title: true,
									language: true
								}
							}
						}
					}
				}
			}
		},
		where: {
			username
		}
	});
}
