import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { saveDemoPost } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const PUT: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await saveDemoPost(event.params.id, await event.request.json()));
};
