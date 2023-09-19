import type { PageServerLoad } from './$types';

export const load = (async ({ fetch, params, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	const search = await fetch(`/api/search/all/${params.query}/1`).then((res) => res.json());
	return { search, params };
}) satisfies PageServerLoad;
