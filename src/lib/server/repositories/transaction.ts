import { prisma } from '$lib/server/database/prisma';

export function get(to_user_id: bigint) {
	return prisma.transactions.findMany({
		where: {
			to_user_id
		},
		orderBy: {
			id: 'desc'
		}
	});
}