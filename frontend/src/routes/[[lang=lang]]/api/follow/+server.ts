import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { setDemoFollow } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	return Response.json(await setDemoFollow(body.followable_id, true));
};

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	return Response.json(await setDemoFollow(body.followable_id, false));
};
