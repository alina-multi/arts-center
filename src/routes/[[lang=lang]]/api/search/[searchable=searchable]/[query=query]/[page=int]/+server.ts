import type { RequestHandler } from './$types';

import { doMeiliSearch } from '$lib/helpers/doMeiliSearch';
import { cacheGet } from '$lib/server/database/cache';
import { unslug } from '$lib/helpers/url';

export const GET = (async ({ params, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	params.query = unslug(params.query);
	return new Response(
		await cacheGet(
			'search',
			`${params.searchable}.${params.query}.${params.page}`,
			async () => {
				let search;
				if (params.searchable !== 'all') {
					search = await doMeiliSearch(params.searchable, params.query, params.page);
				} else {
					const [users, works] = await Promise.all([
						doMeiliSearch('users', params.query, params.page),
						doMeiliSearch('works', params.query, params.page)
					]);
					search = { users, works };
				}
				return JSON.stringify(search);
			},
			60 * 60
		)
	);
}) satisfies RequestHandler;
