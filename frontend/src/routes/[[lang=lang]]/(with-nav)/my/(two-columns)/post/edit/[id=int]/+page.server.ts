import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/post';
import { generateSignature } from '$lib/server/transloadit';
import { error } from '@sveltejs/kit';
import { postMap } from '$lib/server/mappers/post';

export const load = (async ({ params, parent }) => {
	const { user } = await parent();
	const postRaw = await get(params.id);
	if (!postRaw) {
		error(404);
	}
	if (postRaw?.owner?.id != user.id) {
		error(403, {
			message: 'Unauthorized'
		});
	}
	if (!process.env.TRANSLOADIT_IMAGE_TEMPLATE) {
		error(500, {
			message: 'Missing Transloadit Image Template'
		});
	}
	return {
		post: postMap(postRaw),
		transloadit: generateSignature(process.env.TRANSLOADIT_IMAGE_TEMPLATE)
	};
}) satisfies PageServerLoad;
