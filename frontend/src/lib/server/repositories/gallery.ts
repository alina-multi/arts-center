import type { Prisma } from '@prisma/client';
import { titleToId } from './tag';
import { error } from '@sveltejs/kit';
import { userSelect } from './user';
import { imageSelect } from '$lib/server/repositories/image';
import { prisma } from '$lib/server/database/prisma';
import type { AvailableLocales } from '$lib/translations';

const trendingOrRisingRatingCutoff = 20;

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

export async function trendingRandomIndexQuery() {
	const ids = await prisma.$queryRaw`
        SELECT id
        FROM works
        WHERE rating >= ${trendingOrRisingRatingCutoff}
          AND featured_at <= NOW()
        ORDER BY rand()
        LIMIT 0,6
    `;

	return prisma.works.findMany({
		select: gallerySelect,
		where: {
			id: { in: ids.map(({ id }) => id) }
		}
	});
}

export function newAndRisingIndexQuery() {
	return query(
		{
			featured_at: { lte: new Date() },
			rating: { lt: trendingOrRisingRatingCutoff }
		},
		{
			featured_at: 'desc'
		},
		1,
		6
	);
}

export async function userQuery(user_id: bigint, tag = 'all', lang = 'en', page = 1) {
	let where = {};
	if (tag !== 'all') {
		const id = await titleToId(tag, lang);
		if (!id) error(404, { message: `Tag: ${tag} not found` });
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
		if (!id) error(404, { message: `Tag: ${tag} not found` });
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
				gte: 30
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

	if (order === 'trending') {
		where = {
			...where,
			featured_at: { lte: new Date() },
			rating: { gte: trendingOrRisingRatingCutoff }
		};
	}

	if (order === 'rising') {
		where = {
			...where,
			featured_at: { lte: new Date() },
			rating: { lt: trendingOrRisingRatingCutoff }
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
