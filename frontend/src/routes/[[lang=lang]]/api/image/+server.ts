import { proxyApi } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { getDemoState, parseTempId } from '$lib/server/mock/session';
import { pictureFromUrl } from '$lib/server/mappers/pictures';
import { error } from '@sveltejs/kit';
import type { RequestHandler } from './$types';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) return proxyApi(event);
	const body = await event.request.json();
	const state = getDemoState();
	const pictures = (body.images || []).map((value: string) => {
		const id = parseTempId(value);
		const image = state?.images[id];
		if (!image) error(400, 'Upload not found');
		return { id: Number(id), ...pictureFromUrl(image.url) };
	});
	return Response.json(pictures);
};
