import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { deleteDemoImage, setDemoMainImage } from '$lib/server/mock/session';
import type { RequestHandler } from './$types';

export const PUT: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await setDemoMainImage(event.params.id, event.params.image));
};

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await deleteDemoImage(event.params.id, event.params.image));
};
