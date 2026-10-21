import { prisma } from '$lib/server/database/prisma';
import { imageSelect } from '$lib/server/repositories/image';
import { userSelect } from '$lib/server/repositories/user';
import { useMockData } from '$lib/server/mock/mode';
import { mockPostGet, mockPostsQuery, mockUserPosts } from '$lib/server/mock/read';

const PAGE_SIZE = 10;
const postSelect = {
	id: true,
	rating: true,
	comments: true,
	published_at: true,
	updated_at: true,
	title: true,
	body: true,
	language: true,
	owner: {
		select: userSelect
	},
	image: imageSelect,
	images: {
		select: {
			image: imageSelect
		},
		where: {
			imageable_type: 'post'
		}
	}
};

export function query(where = {}, orderBy = {}, page = 1) {
	if (useMockData()) {
		return Promise.resolve(mockPostsQuery(where as Record<string, unknown>, orderBy, page));
	}
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

export function get(id: string, where = {}) {
	if (useMockData()) {
		return Promise.resolve(mockPostGet(id, where as Record<string, unknown>));
	}
	return prisma.posts.findUnique({
		select: postSelect,
		where: {
			id,
			...where
		}
	});
}

export function userAllPostsQuery(user_id: string) {
	if (useMockData()) {
		return Promise.resolve(mockUserPosts(user_id));
	}
	return prisma.posts.findMany({
		select: postSelect,
		where: {
			user_id,
			deleted_at: null
		},
		orderBy: {
			published_at: 'desc'
		}
	});
}
