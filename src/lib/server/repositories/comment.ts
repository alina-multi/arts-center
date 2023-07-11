import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});

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
					avatar: true
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
