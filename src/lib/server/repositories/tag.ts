import { prisma } from '$lib/server/database/prisma';
import { unslug } from '$lib/helpers/url';

let categoryCache: {
	id: bigint;
	count: number | null;
	titles: {
		language: string;
		title: string;
	}[];
}[];

let categoryTitleToId = new Map();

export async function getCategories() {
	if (!categoryCache) {
		categoryCache = await prisma.tags.findMany({
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
		console.log('just set category cache:', categoryCache)
	}
	return categoryCache;
}

export async function titleToId(title: string, language: string) {
	if (categoryTitleToId.size === 0) {
		const categories = await getCategories();
		categories.forEach((tag) => {
			tag.titles.forEach((title) => {
				categoryTitleToId.set(`${title.language}.${title.title}`, tag.id);
			});
		});
	}
	title = unslug(title);
	return categoryTitleToId.get(`${language}.${title}`);
}
