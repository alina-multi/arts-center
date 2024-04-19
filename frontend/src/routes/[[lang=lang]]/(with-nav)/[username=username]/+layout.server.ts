import { get } from '$lib/server/repositories/user';
import { userMap } from '$lib/server/mappers/users';
import { error } from '@sveltejs/kit';
import type { LayoutServerLoad } from './$types';
import { cacheGet } from '$lib/server/database/cache';
export const load = (async ({ params, setHeaders }) => {
	params.tag ??= 'all';

	const data = await cacheGet(
		'user',
		`${params.username}.${params.lang}`,
		async () => {
			const userRaw = await get(params.username);
			if (!userRaw || !userRaw.approved_at) error(404, 'User not found');
			const user = await userMap(userRaw, params.lang);
			return {
				user,
				params
			};
		},
		60
	);

	// Important to add headers here, after potential 404 we don't want to cache it
	setHeaders({
		'cache-control': 'max-age=600'
	});

	return data;
}) satisfies LayoutServerLoad;
