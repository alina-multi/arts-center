import { usersMap } from '$lib/server/mappers/users';
import { query } from '$lib/server/repositories/user';
import type { PageServerLoad } from './$types';

export const load = (async ({ params }) => {
	let users = await query();
	users = await usersMap(users);
	return structuredClone(
		{
			users
		}
	)
}) satisfies PageServerLoad;
