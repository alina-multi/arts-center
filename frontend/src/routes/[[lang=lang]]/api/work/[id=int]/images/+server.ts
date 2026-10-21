import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { attachDemoImages } from '$lib/server/mock/session';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	return Response.json(await attachDemoImages(event.params.id, body.images || []));
};
