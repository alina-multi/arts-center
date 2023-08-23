import { MeiliSearch } from 'meilisearch';

const client = new MeiliSearch({
    host: 'https://ms-592552fd0ab4-4380.fra.meilisearch.io/',
    apiKey: process.env.MEILISEARCH_KEY
});


export async function doMeiliSearch(searchable, query, page ) {
     query = query.split('-').join(' ');
	const index = client.index(searchable);
	const search = await index.search(query, {
		page: parseInt(page)
	});
    return search;
}
