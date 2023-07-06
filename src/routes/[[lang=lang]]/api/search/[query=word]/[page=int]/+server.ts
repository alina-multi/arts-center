import type { RequestHandler } from './$types';
import { MeiliSearch } from 'meilisearch';

export const GET = (async ({ params }) => {
	const client = new MeiliSearch({
		host: 'https://ms-592552fd0ab4-4380.fra.meilisearch.io/',
		apiKey: process.env.MEILISEARCH_KEY
	});

	const index = client.index('users');
	const search = await index.search(params.query, {
		page: parseInt(params.page)
	});

	return new Response(JSON.stringify(search));
}) satisfies RequestHandler;
