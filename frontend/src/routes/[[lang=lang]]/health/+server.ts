import type { RequestHandler } from './$types';

export const GET = (async () => {
	return new Response('OK');
}) satisfies RequestHandler;
