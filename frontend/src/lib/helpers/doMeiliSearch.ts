import { MeiliSearch } from 'meilisearch';

const client = new MeiliSearch({
	host: 'https://search.arts.center/',
	apiKey: process.env.MEILISEARCH_KEY
});

export async function doMeiliSearch(searchable, query, page) {
	let search;
	try {
		const index = client.index(searchable);
		search = await index.search(query, {
			page: parseInt(page)
		});
	} catch (e) {
		console.error(e);
		search = [];
	}
	return search;
}
