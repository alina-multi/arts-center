import { error } from '@sveltejs/kit';
import type { RequestHandler } from './$types';
import { useMockData } from '$lib/server/mock/mode';
import { saveDemoImage } from '$lib/server/mock/session';

export const POST: RequestHandler = async ({ request }) => {
	if (!useMockData()) error(404, 'Not found');
	const form = await request.formData();
	const file = form.get('file');
	if (!(file instanceof File)) error(400, 'Choose an image');
	const saved = await saveDemoImage(file);
	return new Response(JSON.stringify(saved), {
		headers: { 'content-type': 'application/json' }
	});
};
