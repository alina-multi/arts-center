import { get } from '$lib/server/repositories/user';
import { userMap } from '$lib/server/mappers/users';
import { userQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { error } from '@sveltejs/kit';

export const load = async ({ params }) => {
	const userRaw = await get(params.username);
	if (!userRaw) throw error(404, 'User not found');
	const user = await userMap(userRaw);
	const gallery = await worksPreviewMap(await userQuery(user.id));
	return {
		user,
		gallery,
		params: { ...params, tag: params.tag || 'all' }
	};
};
