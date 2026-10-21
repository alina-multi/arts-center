import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { unpublishDemoWork } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await unpublishDemoWork(event.params.id));
};
