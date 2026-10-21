import { error } from '@sveltejs/kit';
import type { RequestHandler } from './$types';
import { useMockData } from '$lib/server/mock/mode';
import { seedDemoAccount, setDemoCookie } from '$lib/server/mock/session';

export const POST: RequestHandler = async (event) => {
	if (!useMockData()) error(404, 'Not found');
	const body = await event.request.json();
	if (!body?.sessionId || !/^[0-9a-f-]{36}$/i.test(body.sessionId) || !body.email || !body.id) {
		error(400, 'Unknown account');
	}
	await seedDemoAccount(body.sessionId, {
		id: String(body.id),
		username: String(body.username || 'artist'),
		name: body.name,
		email: String(body.email),
		country: body.country
	});
	setDemoCookie(event.cookies, body.sessionId, event.url.protocol === 'https:');
	return Response.json({ ok: true });
};
