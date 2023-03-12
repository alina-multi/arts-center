import type { Tag } from '$lib/interfaces/Tag';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});
prisma.$on('query', (e) => {
	console.log('Query: ' + e.query);
	console.log('Params: ' + e.params);
	console.log('Duration: ' + e.duration + 'ms');
});
export function getCategories() {
	return prisma.tags.findMany({
		select: {
			id: true,
			count: true,
			titles: {
				select: {
					title: true,
					language: true
				}
			}
		},
		where: {
			type_id: 1
		},
		orderBy: {
			count: 'desc'
		}
	});
}
