import type { PageLoad } from './$types';
import { get } from '$lib/server/repositories/work';
import { workMap } from '$lib/server/mappers/work';

export const  load = (async ({ params }) => {
	const work = workMap(await get(BigInt(params.id)));
	return {
		work
	};
}) satisfies PageLoad;
