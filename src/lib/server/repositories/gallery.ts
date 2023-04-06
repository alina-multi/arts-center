import type { Prisma } from '@prisma/client';
import { PrismaClient } from '@prisma/client';
import { titleToId } from './tag';
import { error } from '@sveltejs/kit';

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});

export function query(
	where: Prisma.worksWhereInput = {},
	orderBy: Prisma.worksOrderByWithRelationInput = {},
	page = 0,
	perPage = 20
) {
	return prisma.works.findMany({
		take: perPage,
		skip: page * perPage,
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
			image: {
				select: {
					id: true,
					name: true,
					folder: true,
					w300: true,
					w600: true
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
			}
		},
		where: {
			published_at: { lte: new Date() },
			deleted_at: null,
			...where
		},
		orderBy
	});
}

export function indexQuery(page = 0) {
	return query(
		{
			rating: {
				gte: 20
			}
		},
		{
			published_at: 'desc'
		},
		page
	);
}

export async function userQuery(user_id: bigint, page = 0) {
	return query(
		{
			owners: {
				some: {
					user_id,
					ownable_type: 'work'
				}
			}
		},
		{
			published_at: 'desc'
		},
		page
	);
}

export async function filteredQuery(tag: string, lang: string, order = 'popular', page = 0) {
	let where = {};
	if (tag !== 'all') {
		const tagTitle = await titleToId(tag, lang);
		if (!tagTitle) throw error(404, { message: `Tag: ${tag} not found` });
		where = {
			tags: {
				some: {
					tag_id: {
						equals: tagTitle.tag_id
					},
					taggable_type: 'work'
				}
			}
		};
	}

	if (order === 'popular') {
		where = {
			...where,
			rating: {
				gte: 20
			}
		};
	}

	if (order === 'sale') {
		where = {
			...where,
			price: {
				gt: 0
			}
		};
	}

	return query(
		where,
		{
			published_at: 'desc'
		},
		page
	);
}
