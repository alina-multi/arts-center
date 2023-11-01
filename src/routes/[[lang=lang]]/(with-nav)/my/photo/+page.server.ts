import type { PageServerLoad } from './$types';
import { generateSignature } from '$lib/server/transloadit';

export const load = (async () => {
	return {
		transloadit: generateSignature(process.env.TRANSLOADIT_PHOTO_TEMPLATE)
	};
}) satisfies PageServerLoad;
