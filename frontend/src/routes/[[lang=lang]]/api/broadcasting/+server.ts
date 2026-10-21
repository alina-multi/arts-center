import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import type { RequestHandler } from './$types';

const quiet = () => Response.json({ ok: true });

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return quiet();
};

export const GET: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return quiet();
};

export const HEAD: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	return new Response(null, { status: 204 });
};
