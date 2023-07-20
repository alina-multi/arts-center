import type { PageServerLoad } from './$types';

export const load = (async ({ fetch, params }) => {
	const res = await fetch(`/api/search/${params.query}/1`);
	return { search: await res.json(), query: params.query };
}) satisfies PageServerLoad;
