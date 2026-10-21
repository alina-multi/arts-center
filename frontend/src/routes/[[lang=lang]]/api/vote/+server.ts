import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { setDemoVote } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await setDemoVote(await event.request.json()));
};

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await setDemoVote(await event.request.json(), true));
};
