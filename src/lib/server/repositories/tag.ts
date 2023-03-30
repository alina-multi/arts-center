import type { Tag } from '$lib/interfaces/Tag';
import { PrismaClient, tag_titles } from '@prisma/client';

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
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

export function titleToId(title: string, language: string) {
	return prisma.tag_titles.findFirst({
		select: {
			tag_id: true
		},
		where: {
			title: {
				equals: title
			},
			language: {
				equals: language
			}
		}
	});
}
