import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { redirect } from '@sveltejs/kit';
import type { RequestHandler } from './$types';

export const GET: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	redirect(302, '/login?google=1');
};
