import { error, redirect } from '@sveltejs/kit';
import type { RequestHandler } from './$types';
import { useMockData } from '$lib/server/mock/mode';
import { readDemoImage, readSessionId } from '$lib/server/mock/session';

export const GET: RequestHandler = async ({ params, cookies }) => {
	if (!useMockData()) error(404, 'Not found');
	const sessionId = readSessionId(cookies);
	if (!sessionId) error(404, 'Not found');
	const image = await readDemoImage(sessionId, params.id);
	if ('redirect' in image && image.redirect) redirect(302, image.redirect);
	return new Response(image.bytes, {
		headers: {
			'content-type': image.contentType,
			'cache-control': 'private, max-age=3600'
		}
	});
};
