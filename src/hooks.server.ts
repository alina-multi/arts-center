import type { Handle, HandleServerError } from '@sveltejs/kit';
import { checkUrlLocale } from '$lib/translations';
import * as SentryNode from '@sentry/node';
import '@sentry/tracing';
import { api } from './lib/server/api';
import { cacheGet } from '$lib/server/database/cache';

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
	environment: process.env.NODE_ENV
});

SentryNode.setTag('svelteKit', 'server');

async function checkAuth(event) {
	const session = event?.cookies?.get('laravel_session');
	if (session) {
		const user = await cacheGet(
			session,
			async () => {
				let response = await api({ method: 'GET', path: '/api2/me', event });
				if (response.ok) {
					return await response.json();
				}
			},
			360
		);
		event.locals.user = user;
	}
}

// use handleError to report errors during server-side data loading
export const handleError = (({ error, event }) => {
	SentryNode.captureException(error, { contexts: { sveltekit: { event } } });

	return {
		message: JSON.stringify(error),
	};
}) satisfies HandleServerError;
