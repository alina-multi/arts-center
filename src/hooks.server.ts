import type { Handle, HandleServerError } from '@sveltejs/kit';
import { checkUrlLocale, defaultLocale } from '$lib/translations';
import * as SentryNode from '@sentry/node';
import '@sentry/tracing';
import { env } from '$env/dynamic/public';

export const handle: Handle = async ({ event, resolve }) => {
	event.params.lang ??= defaultLocale;
	console.log(`${event.request.method} ${event.url.pathname}`);
	return resolve(event, {
		transformPageChunk: ({ html }) => html.replace('%lang%', checkUrlLocale(event))
	});
};

SentryNode.init({
	dsn: 'https://c2838269ac4d4b72995864bb70794bab@o740081.ingest.sentry.io/4504873190424576',
	tracesSampleRate: 0.01,
	// Add the Http integration for tracing
	integrations: [new SentryNode.Integrations.Http()],
	environment: env.PUBLIC_ENV
});

SentryNode.setTag('svelteKit', 'server');

// use handleError to report errors during server-side data loading
export const handleError = (({ error, event }) => {
	// We don't need not found errors in sentry
	if (['staging', 'production'].includes(env.PUBLIC_ENV)) {
		if (!error?.message.startsWith('Not found:')) {
			SentryNode.captureException(error, { contexts: { sveltekit: { event } } });
		}
	}

	if (env.PUBLIC_ENV !== 'development') {
		console.error(error);
		return;
	}
	return {
		message: error?.stack ?? error?.message
	};
}) satisfies HandleServerError;
