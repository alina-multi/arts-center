import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { addDemoComment, deleteDemoComment, editDemoComment } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	if (event.params.id) return Response.json(await editDemoComment(event.params.id, body.text));
	return Response.json(await addDemoComment(body));
};

export const PUT: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	return Response.json(await editDemoComment(event.params.id, body.text));
};

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await deleteDemoComment(event.params.id));
};
