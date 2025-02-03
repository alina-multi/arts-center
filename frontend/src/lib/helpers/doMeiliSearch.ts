import { MeiliSearch } from 'meilisearch';

const client = new MeiliSearch({
	host: 'https://search.arts.center/',
	apiKey: process.env.MEILISEARCH_KEY
});

export async function doMeiliSearch(searchable, query, page) {
	const index = client.index(searchable);
	const search = await index.search(query, {
		page: parseInt(page)
	});
	return search;
}
