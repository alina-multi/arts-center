import type { RequestHandler } from './$types';

import { doMeiliSearch } from '$lib/helpers/doMeiliSearch';

export const GET = (async ({ params }) => {
	let search;
	if (params.searchable !== 'all') {
		search = await doMeiliSearch(params.searchable, params.query, params.page);
	} else {
		const users = await doMeiliSearch('users', params.query, params.page);
		const works = await doMeiliSearch('works', params.query, params.page);
		search = { users, works };
	}

	return new Response(JSON.stringify(search));
}) satisfies RequestHandler;
