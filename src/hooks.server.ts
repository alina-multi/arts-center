import type { Handle, HandleServerError } from '@sveltejs/kit';
import { checkUrlLocale, defaultLocale } from '$lib/translations';
import * as SentryNode from '@sentry/node';
import '@sentry/tracing';
import { PUBLIC_ENV } from '$env/static/public';

export const handle: Handle = async ({ event, resolve }) => {
	event.params.lang ??= defaultLocale;
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
