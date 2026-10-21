import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { demoFollowing } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) return { users: demoFollowing(event.params.lang) };
	const response = await api({ method: 'GET', path: '/api2/follow', event });
	const following = await response.json();

	return {
		users: following.users
	};
}) satisfies PageServerLoad;
