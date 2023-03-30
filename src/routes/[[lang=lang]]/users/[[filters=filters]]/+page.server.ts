import { usersMap } from '$lib/server/mappers/users';
import { query } from '$lib/server/repositories/user';
import type { PageServerLoad } from './$types';

export const load = (async ({ params }) => {
	return {
		users: usersMap(await query())
	};
}) satisfies PageServerLoad;
