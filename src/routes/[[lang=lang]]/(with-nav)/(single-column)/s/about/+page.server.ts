import type { PageServerLoad } from './$types';
import { cacheGet } from '$lib/server/database/cache';

export const load = (async ({ setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=6000'
	});
	// Todo: get from DB :)
	return cacheGet(
		'page',
		'about',
		async () => {
			return {
				"artists": 12773,
				"artworks": 423711,
				"comments": 2159447
			}
		},
		30
	);
}) satisfies PageServerLoad;
