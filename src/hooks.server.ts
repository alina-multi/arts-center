import type { Handle, HandleServerError } from '@sveltejs/kit';
import { checkUrlLocale } from '$lib/translations';
import * as SentryNode from '@sentry/node';
import '@sentry/tracing';

export const handle = (({ event, resolve }) => {
	return resolve(event, {
		transformPageChunk: ({ html }) => html.replace('%lang%', checkUrlLocale(event))
	});
}) satisfies Handle;

SentryNode.init({
	dsn: 'https://c2838269ac4d4b72995864bb70794bab@o740081.ingest.sentry.io/4504873190424576',
	tracesSampleRate: 0.01,
	// Add the Http integration for tracing
	integrations: [new SentryNode.Integrations.Http()],
	environment: process.env.NODE_ENV
});

SentryNode.setTag('svelteKit', 'server');

// use handleError to report errors during server-side data loading
export const handleError = (({ error, event }) => {
	SentryNode.captureException(error, { contexts: { sveltekit: { event } } });

	return {
		message: error.message,
	};
}) satisfies HandleServerError;
