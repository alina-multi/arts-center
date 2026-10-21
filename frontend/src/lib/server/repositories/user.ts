import type { Prisma } from '@prisma/client';
import { prisma } from '$lib/server/database/prisma';
import { titleToId } from './tag';
import { error } from '@sveltejs/kit';
import { imageSelect } from '$lib/server/repositories/image';
import type { AvailableLocales } from '$lib/translations';
import { useMockData } from '$lib/server/mock/mode';
import { mockUserCountries, mockUserGet, mockUsersQuery } from '$lib/server/mock/read';

export const userSelect = {
	id: true,
	username: true,
	name: true,
	photo: imageSelect,
	country: true,
	rating: true,
	verified_at: true,
	approved_at: true,
	created_at: true
};

const PAGE_SIZE = 10;

export function query(
	where: Prisma.usersWhereInput = {},
	orderBy: Prisma.usersOrderByWithRelationInput = {},
	page = 1
) {
	if (useMockData()) {
		return Promise.resolve(mockUsersQuery(where as Record<string, unknown>, orderBy, page));
	}
	page--;
	return prisma.users.findMany({
		take: PAGE_SIZE,
		skip: page * PAGE_SIZE,
		select: {
			...userSelect
		},
		where: {
			country: {
				not: 'ru'
			},
			approved_at: {
				not: null
			},
			deleted_at: null,
			...where
		},
		orderBy
	});
}

export function get(username: string) {
	if (useMockData()) {
		return Promise.resolve(mockUserGet(username));
	}
	return prisma.users.findUnique({
		select: {
			...userSelect,
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
	if (useMockData()) {
		return Promise.resolve(mockUserCountries());
	}
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
			country: {
				notIn: ['ru']
			},
			deleted_at: null
		}
	});
}

export async function filteredQuery(
	category: string,
	country: string,
	order = 'popular',
	lang: AvailableLocales,
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
		const id = await titleToId(category, lang);
		if (!id) error(404, `Tag not found, ${category}`);
		where = {
			...where,
			ratings: {
				some: {
					ratable_id: { equals: id },
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
