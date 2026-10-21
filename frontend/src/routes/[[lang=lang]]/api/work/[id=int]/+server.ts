import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { deleteDemoWork } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await deleteDemoWork(event.params.id));
};
