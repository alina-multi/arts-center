import { get } from '$lib/server/repositories/user';
import { userMap } from '$lib/server/mappers/users';
import { userQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { error } from '@sveltejs/kit';
import type { LayoutServerLoad } from './$types';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ params, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=6000'
	});

	return await cacheGet(
		'user',
		params.username,
		async () => {
			const userRaw = await get(params.username);
			if (!userRaw) throw error(404, 'User not found');
			const user = await userMap(userRaw);
			const gallery = await worksPreviewMap(await userQuery(user.id));
			return {
				user,
				gallery,
				params: { tag: 'all', ...params }
			};
		},
		5
	);
}) satisfies LayoutServerLoad;
