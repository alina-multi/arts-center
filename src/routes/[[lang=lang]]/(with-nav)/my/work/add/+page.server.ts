import type { PageServerLoad } from './$types';
import { generateSignature } from '$lib/server/transloadit';

export const load = (async ({params}) => {
	const template_id = '4ca437087e4446d7a5d1fe1561de04eb';
	return {
		params,
		transloadit: generateSignature(template_id)
	};
}) satisfies PageServerLoad;
