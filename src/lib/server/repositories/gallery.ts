import type { Prisma } from '@prisma/client';
import { titleToId } from './tag';
import { error } from '@sveltejs/kit';
import { userSelect } from './user';
import { imageSelect } from '$lib/server/repositories/image';
import { prisma } from '$lib/server/database/prisma';
import type { user_basic_raw} from './user';
import type { image_raw } from '$lib/server/repositories/image';
import type { tag_titles_row } from './tag';


export interface works_raw {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number;
	preview: image_raw | null;
	status?: number;
	images: { image: image_raw }[] | [];
	titles: tag_titles_row [];
	owners: { user: user_basic_raw }[];
}


export function query(
	where: Prisma.worksWhereInput = {},
	orderBy: Prisma.worksOrderByWithRelationInput = {},
	page = 1,
	perPage = 20,
	select = {}
) {
	page--;
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
			preview: imageSelect,
			...select,
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
		},
		where: {
			status: { gte: 40 },
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
		{
			published_at: 'desc'
		},
		page
	);
}

export async function userAllWorksQuery(user_id: bigint) {
	return query(
		{
			deleted_at: null,
			// Silly, but the only way I see to overload it :)
			status: undefined,
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

export async function filteredQuery(tag: string, lang: string, order = 'popular', page = 1) {
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
