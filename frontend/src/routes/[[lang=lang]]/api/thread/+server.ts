import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { startDemoThread } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	return Response.json(await startDemoThread(body.participants?.[0], body.title));
};
