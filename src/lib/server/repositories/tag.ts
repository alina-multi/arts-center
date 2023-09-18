import { prisma } from '$lib/server/database/prisma';

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
	title = title.replaceAll('_', ' ');
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
