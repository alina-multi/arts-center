import type { RequestHandler } from './$types';
import devalue from 'devalue';
import { checkAuth } from '$lib/server/auth';

export const POST = (async (event) => {
	return new Response(devalue.stringify(await checkAuth(event)));
}) satisfies RequestHandler;
