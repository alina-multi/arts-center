import { prisma } from '$lib/server/database/prisma';

const PAGE_SIZE = 10;
const postSelect = {
	id: true,
	rating: true,
	comments: true,
	published_at: true,
	user_id: true,
	title: true,
	body: true
	// image: { select: imageSelect },
	// user: { select: userSelect }
};

export function query(where = {}, orderBy = {}, page = 1) {
	page--;
	return prisma.posts.findMany({
		take: PAGE_SIZE,
		skip: page * PAGE_SIZE,
		select: postSelect,
		where: {
			deleted_at: null,
			published_at: {
				not: null
			},
			...where
		},
		orderBy
	});
}

export function get(id: string) {
	return prisma.posts.findUnique({
		select: postSelect,
		where: {
			id
		}
	});
}
