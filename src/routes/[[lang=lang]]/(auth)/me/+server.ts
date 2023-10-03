import type { RequestHandler } from './$types';
import { stringify } from 'devalue';
import { checkAuth } from '$lib/server/auth';

export const POST = (async (event) => {
	return new Response(stringify(await checkAuth(event)));
}) satisfies RequestHandler;
