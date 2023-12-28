import type { Prisma } from '@prisma/client';
import { titleToId } from './tag';
import { error } from '@sveltejs/kit';
import { userSelect } from './user';
import { imageSelect } from '$lib/server/repositories/image';
import { prisma } from '$lib/server/database/prisma';
import type { AvailableLocales } from '$lib/translations';

export const gallerySelect = {
	id: true,
	published_at: true,
	rating: true,
	comments: true,
	hosts: true,
	price: true,
	preview: imageSelect,
	titles: {
		select: {
			title: true,
			language: true
		}
	},
	owners: {
		select: {
			user: {
				select: userSelect
			}
		},
		where: {
			ownable_type: 'work'
		}
	}
};

export function query(
	where: Prisma.worksWhereInput = {},
	orderBy: Prisma.worksOrderByWithRelationInput | Prisma.worksOrderByWithRelationInput[] = {},
	page = 1,
	perPage = 20,
	select = {}
) {
	page--;
	return prisma.works.findMany({
		take: perPage,
		skip: page * perPage,
		select: {
			...gallerySelect,
			...select
		},
		where: {
			status: { gte: 40 },
			published_at: { lte: new Date() },
			...where
		},
		orderBy
	});
}

export function indexQuery(page = 1) {
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

export async function userQuery(user_id: bigint, tag = 'all', lang = 'en', page = 1) {
	let where = {};
	if (tag !== 'all') {
		const id = await titleToId(tag, lang);
		if (!id) throw error(404, { message: `Tag: ${tag} not found` });
		where = {
			tags: {
				some: {
					tag_id: {
						equals: id
					},
					taggable_type: 'work'
				}
			}
		};
	}
	return query(
		{
			...where,
			owners: {
				some: {
					user_id,
					ownable_type: 'work'
				}
			}
		},
		[
			{
				published_at: 'desc'
			},
			{
				id: 'desc'
			}
		],
		page
	);
}

export async function userAllWorksQuery(user_id: bigint) {
	return query(
		{
			deleted_at: null,
			// Silly, but the only way I see to overload it :)
			status: undefined,
			published_at: undefined,
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
		1,
		100000,
		{
			status: true
		}
	);
}

export async function filteredQuery(
	tag: string,
	lang: AvailableLocales,
	order = 'popular',
	page = 1
) {
	let where = {};
	if (tag !== 'all') {
		const id = await titleToId(tag, lang);
		if (!id) throw error(404, { message: `Tag: ${tag} not found` });
		where = {
			tags: {
				some: {
					tag_id: {
						equals: id
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
				gte: 5
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
