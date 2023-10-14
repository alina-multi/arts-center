import { prisma } from '$lib/server/database/prisma';
import { unslug } from '$lib/helpers/url';
import type { CategoryRaw } from '$lib/interfaces/raw/CategoryRaw';

let categoryCache: CategoryRaw[];

const categoryTitleToId = new Map();

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
