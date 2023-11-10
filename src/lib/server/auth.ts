import type { RequestEvent, ServerLoadEvent } from '@sveltejs/kit';
import { cacheGet } from '$lib/server/database/cache';
import { api } from '$lib/server/api';
import * as SentryNode from '@sentry/node';
import { redirect } from '@sveltejs/kit';
import { localePath } from '$lib/translations';
import type { UserMe } from '$lib/interfaces/User';

export async function checkAuth(
	event: RequestEvent<Partial<Record<string, string>>, string | null>
): Promise<UserMe | undefined> {
	try {
		// Make sure it will still work if auth server is down
		const session = event?.cookies?.get('laravel_session');
		if (session) {
			const response = await api({ method: 'GET', path: '/api2/me', event });
			if (response.ok) {
				return await response.json();
			}
		}
	} catch (error) {
		SentryNode.captureException(error, { contexts: { sveltekit: { event } } });
	}
}

export async function redirectIfAuthorized({ parent }: ServerLoadEvent) {
	const { user } = await parent();
	if (user?.id) {
		throw redirect(302, localePath('/'));
	}
}
