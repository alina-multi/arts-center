import type { PageServerLoad } from './$types';
import { error } from '@sveltejs/kit';
import { get } from '$lib/server/repositories/transaction';

export const load = (async ({parent}) => {
	const { user } = await parent();
	if (!user?.id) {
		throw error(404);
	}
	return {
		transactions: await get(user.id)
	}
}) satisfies PageServerLoad;
