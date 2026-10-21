import { prisma } from '$lib/server/database/prisma';
import { unslug } from '$lib/helpers/url';
import type { CategoryRaw } from '$lib/interfaces/CategoryRaw';
import { useMockData } from '$lib/server/mock/mode';
import { mockCategories } from '$lib/server/mock/read';

let categoryCache: CategoryRaw[];

const categoryTitleToId = new Map();

export async function getCategories() {
	if (!categoryCache) {
		if (useMockData()) {
			categoryCache = mockCategories();
			return categoryCache;
		}
		categoryCache = await prisma.tags.findMany({
			select: {
				id: true,
				count: true,
				deleted_at: true,
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
		const categories = await getCategories({ not: null });
		categories.forEach((tag) => {
			tag.titles.forEach((title) => {
				categoryTitleToId.set(`${title.language}.${title.title}`, tag.id);
				categoryTitleToId.set(`${title.language}.${title.title.toLowerCase()}`, tag.id);
			});
		});
	}
	title = unslug(title);
	return (
		categoryTitleToId.get(`${language}.${title}`) ??
		categoryTitleToId.get(`${language}.${title.toLowerCase()}`)
	);
}
