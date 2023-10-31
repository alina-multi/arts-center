import { prisma } from '$lib/server/database/prisma';
import { gallerySelect } from '$lib/server/repositories/gallery';

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
			photo: true
		}
	}
};
export function get(commentable_id: bigint, commentable_type: string) {
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
