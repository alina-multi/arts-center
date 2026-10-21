import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { saveDemoFeedback } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return Response.json(await saveDemoFeedback(await event.request.json()));
};
