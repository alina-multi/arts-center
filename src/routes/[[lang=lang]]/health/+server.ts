import type { RequestHandler } from './$types';

export const GET = (async ({ params }) => {
  return new Response('OK');
}) satisfies RequestHandler;
