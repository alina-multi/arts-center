import type { RequestEvent, ServerLoadEvent } from '@sveltejs/kit';
import { redirect } from '@sveltejs/kit';
import { api } from '$lib/server/api';
import * as SentryNode from '@sentry/node';
import { localePath } from '$lib/translations';
import type { UserMe } from '$lib/interfaces/User';
import { useMockData } from '$lib/server/mock/mode';
import { getDemoState, readSessionId } from '$lib/server/mock/session';
import { pictureFromUrl } from '$lib/server/mappers/pictures';

export async function checkAuth(
	event: RequestEvent<Partial<Record<string, string>>, string | null>
): Promise<UserMe | undefined> {
	if (useMockData()) {
		if (!readSessionId(event.cookies)) return undefined;
		return demoUser();
	}
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

function demoUser(): UserMe | undefined {
	const state = getDemoState();
	const account = state?.account;
	if (!state || !account) return undefined;
	const photoUpload = state.photoId ? state.images[state.photoId] : undefined;
	const works = [
		...new Set(state.folders.flatMap((folder) => folder.workIds.map((id) => BigInt(id))))
	];
	return {
		id: BigInt(account.id),
		username: account.username,
		name: account.name,
		photo: photoUpload ? pictureFromUrl(photoUpload.url) : null,
		country: account.country.toUpperCase(),
		verified_at: new Date().toISOString(),
		blacklists: state.blocks.map((id) => BigInt(id)),
		follows: { user: state.follows.map((id) => BigInt(id)), work: [] },
		favorites: {
			works,
			folders: state.folders.map((folder) => ({ id: BigInt(folder.id), title: folder.title }))
		},
		approved_at: new Date().toISOString(),
		email_verified_at: null,
		role: 1,
		unread: state.notifications.filter((note) => !note.readAt).length,
		threads: Object.fromEntries(state.threads.map((thread) => [thread.participantId, Number(thread.id)])),
		intent: account.intent,
		unread_messages: 0
	};
}

export async function redirectIfAuthorized({ parent, params }: ServerLoadEvent) {
	const { user } = await parent();
	if (user?.id) {
		redirect(302, localePath(params.lang, '/'));
	}
}
