import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { deleteDemoMessage, editDemoMessage } from '$lib/server/mock/actions';
import type { RequestHandler } from './$types';

function ids(event: { url: URL }) {
	const parts = event.url.pathname.split('/').filter(Boolean);
	return { threadId: parts.at(-3) || '', messageId: parts.at(-1) || '' };
}

export const PUT: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	const { threadId, messageId } = ids(event);
	return Response.json(await editDemoMessage(threadId, messageId, body.message));
};

export const DELETE: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const { threadId, messageId } = ids(event);
	return Response.json(await deleteDemoMessage(threadId, messageId));
};
