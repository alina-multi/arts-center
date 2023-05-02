import type { Prisma } from '@prisma/client';
import { PrismaClient } from '@prisma/client';
import { titleToId } from './tag';
import { error } from '@sveltejs/kit';

export const userSelect = {
	id: true,
	username: true,
	name: true,
	avatar: true,
	country: true,
	rating: true
};

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});
const PAGE_SIZE = 10;

export function query(
	where: Prisma.usersWhereInput = {},
	orderBy: Prisma.usersOrderByWithRelationInput = {},
	page = 1
) {
	page--;
	return prisma.users.findMany({
		take: PAGE_SIZE,
		skip: page * PAGE_SIZE,
		select: {
			...userSelect,
			created_at: true
		},
		where,
		orderBy
	});
}

export function get(username: string) {
	return prisma.users.findUnique({
		select: {
			...userSelect,
			created_at: true,
			ratings: {
				select: {
					rating: true,
					language: true,
					tag: {
						select: {
							id: true,
							titles: {
								select: {
									title: true,
									language: true
								}
							}
						}
					}
				},
				where: {
					ratable_type: {
						equals: 'tag'
					}
				}
			},
			bios: {
				select: {
					text: true,
					language: true
				}
			}
		},
		where: {
			username
		}
	});
}

export function userCountries() {
	return prisma.users.groupBy({
		_count: {
			country: true
		},
		by: ['country'],
		orderBy: {
			_count: {
				country: 'desc'
			}
		},
		where: {
			NOT: {
				country: null
			}
		}
	});
}

export async function filteredQuery(
	category: string,
	country: string,
	order = 'popular',
	lang: string,
	page = 1
) {
	let where = {};
	let orderBy = {};
	if (country !== 'all') {
		where = {
			country: {
				equals: country
			}
		};
	}
	if (category !== 'all') {
		const tag_id = (await titleToId(category, lang))?.tag_id;
		if (!tag_id) throw error(404, `Tag not found, ${tag_id}`);
		where = {
			...where,
			ratings: {
				some: {
					ratable_id: { equals: tag_id },
					ratable_type: { equals: 'tag' }
				}
			}
		};
	}
	if (order === 'new') {
		orderBy = {
			created_at: 'desc'
		};
	} else if (order === 'popular') {
		orderBy = {
			rating: 'desc'
		};
	}
	return await query(where, orderBy, page);
}
