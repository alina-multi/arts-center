import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { deleteDemoFolder, renameDemoFolder } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const PUT: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	return Response.json(await renameDemoFolder(event.params.id, body.title));
};

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await deleteDemoFolder(event.params.id));
};
