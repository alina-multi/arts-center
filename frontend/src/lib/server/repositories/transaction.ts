import { prisma } from '$lib/server/database/prisma';

export function get(to_user_id: bigint) {
	return prisma.transactions.findMany({
		select: {
			id: true,
			type: true,
			created_at: true,
			amount_net: true,
			message: true
		},
		where: {
			to_user_id,
			amount_net: { not: null }
		},
		orderBy: {
			id: 'desc'
		}
	});
}
