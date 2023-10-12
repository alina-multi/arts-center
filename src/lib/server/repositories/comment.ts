import { prisma } from '$lib/server/database/prisma';
import type { user_basic_raw } from './user';

export interface comments {
	id: bigint;
	text: string | null;
	rating: number;
	deleted_at: Date | null;
	created_at: Date | null;
	updated_at: Date | null;
	comment_id: bigint | null;
	owner: user_basic_raw;
}

export function get(commentable_id: bigint, commentable_type: string) {
	return prisma.comments.findMany({
		select: {
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
		},
		orderBy: [{ depth: 'asc' }, { id: 'asc' }],
		where: {
			commentable_type,
			commentable_id,
			deleted_at: null
		}
	});
}
