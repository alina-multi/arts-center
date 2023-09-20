import { prisma } from '$lib/server/database/prisma';
import { unslug } from '$lib/helpers/url';

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
	title = unslug(title);
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
