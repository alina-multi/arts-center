import type { RequestHandler } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { clearDemoCookie } from '$lib/server/mock/session';

export const POST = (async (event) => {
	if (useMockData()) {
		clearDemoCookie(event.cookies, event.url.protocol === 'https:');
		return new Response('ok');
	}
	await api({ method: 'POST', path: '/auth/logout', event });
	return new Response('ok');
}) satisfies RequestHandler;
