import type { PageServerLoad } from './$types';
import { indexQuery } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
export const load = (async ({ params }) => {
	return Promise.all([indexQuery()]).then((values) => {
		return {
			gallery: worksPreviewMap(values[0])
		};
	});
}) satisfies PageServerLoad;
