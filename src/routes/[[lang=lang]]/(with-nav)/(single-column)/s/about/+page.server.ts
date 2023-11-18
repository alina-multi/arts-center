import type { PageServerLoad } from './$types';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	// Todo: get from DB :)
	return cacheGet(
		'page',
		'about',
		async () => {
			return {
				artists: '12k+',
				artworks: '420k+',
				comments: '2m+'
			};
		},
		30
	);
}) satisfies PageServerLoad;
