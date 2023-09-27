import type { RequestHandler } from './$types';
import { api } from '$lib/server/api';

export const POST = (async (event) => {
	await api({ method: 'POST', path: '/auth/logout', event });
	return new Response('ok');
}) satisfies RequestHandler;
