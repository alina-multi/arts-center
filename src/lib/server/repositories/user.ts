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
