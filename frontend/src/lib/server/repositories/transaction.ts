import { prisma } from '$lib/server/database/prisma';
import { useMockData } from '$lib/server/mock/mode';
import { demoDonations } from '$lib/server/mock/actions';

export function get(to_user_id: bigint) {
	if (useMockData()) {
		return Promise.resolve(demoDonations());
	}
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
