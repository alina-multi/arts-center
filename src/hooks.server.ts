import type { Handle, HandleServerError, RequestEvent } from '@sveltejs/kit';
import { checkUrlLocale } from '$lib/translations';
import * as SentryNode from '@sentry/node';
import '@sentry/tracing';
import { api } from './lib/server/api';
import { cacheGet } from '$lib/server/database/cache';
import { PUBLIC_ENV } from '$env/static/public';

export const handle: Handle = async ({ event, resolve }) => {
	await checkAuth(event);
	return resolve(event, {
		transformPageChunk: ({ html }) => html.replace('%lang%', checkUrlLocale(event))
	});
};

SentryNode.init({
	dsn: 'https://c2838269ac4d4b72995864bb70794bab@o740081.ingest.sentry.io/4504873190424576',
	tracesSampleRate: 0.01,
	// Add the Http integration for tracing
	integrations: [new SentryNode.Integrations.Http()],
	environment: PUBLIC_ENV
});

SentryNode.setTag('svelteKit', 'server');

async function checkAuth(event: RequestEvent<Partial<Record<string, string>>, string | null>) {
	try {
		// Make sure it will still work if auth server is down
		const session = event?.cookies?.get('laravel_session');
		if (session) {
			const user = await cacheGet(
				'auth',
				session,
				async () => {
					const response = await api({ method: 'GET', path: '/api2/me', event });
					if (response.ok) {
						return await response.json();
					}
				},
				360
			);
			event.locals.user = user;
		}
	} catch (error) {
		if (['staging', 'production'].includes(PUBLIC_ENV)) {
			SentryNode.captureException(error, { contexts: { sveltekit: { event } } });
		}
	}
}

// use handleError to report errors during server-side data loading
export const handleError = (({ error, event }) => {
	// We don't need not found errors in sentry
	if (['staging', 'production'].includes(PUBLIC_ENV)) {
		if (!error?.message.startsWith('Not found:')) {
			SentryNode.captureException(error, { contexts: { sveltekit: { event } } });
		}
	}

	if (PUBLIC_ENV !== 'development') {
		return;
	}
	return {
		message: error?.stack ?? error?.message
	};
}) satisfies HandleServerError;
