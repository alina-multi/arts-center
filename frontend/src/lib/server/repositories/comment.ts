import { prisma } from '$lib/server/database/prisma';
import { imageSelect } from '$lib/server/repositories/image';
import { gallerySelect } from '$lib/server/repositories/gallery';
import { useMockData } from '$lib/server/mock/mode';
import { commentsFor, mockLatestComments } from '$lib/server/mock/read';

const commentSelect = {
	id: true,
	text: true,
	rating: true,
	deleted_at: true,
	created_at: true,
	updated_at: true,
	comment_id: true,
	owner: {
		select: {
			id: true,
			username: true,
			name: true,
			photo: imageSelect
		}
	}
};
export function get(commentable_id: bigint, commentable_type: string) {
	if (useMockData()) {
		return Promise.resolve(commentsFor(commentable_id, commentable_type));
	}
	return prisma.comments.findMany({
		select: commentSelect,
		orderBy: [{ depth: 'asc' }, { id: 'asc' }],
		where: {
			commentable_type,
			commentable_id,
			deleted_at: null
		}
	});
}

export function latest() {
	if (useMockData()) {
		return Promise.resolve(mockLatestComments());
	}
	return prisma.comments.findMany({
		select: {
			...commentSelect,
			work: {
				select: gallerySelect
			}
		},
		orderBy: [{ id: 'desc' }],
		where: {
			commentable_type: 'work',
			deleted_at: null
		},
		take: 10
	});
}
