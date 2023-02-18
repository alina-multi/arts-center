import type { PageServerLoad } from './$types';
import { indexQuery } from '@server/repositories/gallery';
import { worksPreviewMap } from '@server/mappers/gallery';
export const load = (async ({ params }) => {
	const gallery = worksPreviewMap(await indexQuery());
	return {
		gallery
	};
}) satisfies PageServerLoad;
