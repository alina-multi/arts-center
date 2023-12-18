import type { PageServerLoad } from './$types';
import { get } from '$lib/server/repositories/post';
import { generateSignature } from '$lib/server/transloadit';
import { error } from '@sveltejs/kit';

export const load = (async ({ params, parent }) => {
	const { user } = await parent();
	const post = await get(params.id);
	if (post?.user_id != user.id) {
		throw error(403, {
			message: 'Unauthorized'
		});
	}
	if (!process.env.TRANSLOADIT_IMAGE_TEMPLATE) {
		throw error(500, {
      message: 'Missing Transloadit Image Template'
    });
	}
	return {
		post,
		transloadit: generateSignature(process.env.TRANSLOADIT_IMAGE_TEMPLATE)
	};
}) satisfies PageServerLoad;
