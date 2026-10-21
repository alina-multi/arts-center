import type { RequestHandler } from './$types';

import { cacheGet } from '$lib/server/database/cache';
import { unslug } from '$lib/helpers/url';
import { useMockData } from '$lib/server/mock/mode';
import { mockSearch } from '$lib/server/mock/search';

async function runSearch(searchable: string, query: string, page: string) {
	if (useMockData()) {
		return mockSearch(searchable, query, Number(page) || 1);
	}
	const { doMeiliSearch } = await import('$lib/helpers/doMeiliSearch');
	return doMeiliSearch(searchable, query, page);
}

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
					search = await runSearch(params.searchable, params.query, params.page);
				} else {
					const [users, works] = await Promise.all([
						runSearch('users', params.query, params.page),
						runSearch('works', params.query, params.page)
					]);
					search = { users, works };
				}
				return JSON.stringify(search);
			},
			60 * 60
		)
	);
}) satisfies RequestHandler;
