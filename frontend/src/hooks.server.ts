import type { Handle, HandleServerError } from '@sveltejs/kit';
import { checkUrlLocale, defaultLocale } from '$lib/translations';
import * as SentryNode from '@sentry/node';
import '@sentry/tracing';
import { env } from '$env/dynamic/public';
import { prisma } from '$lib/server/database/prisma';
import { useMockData } from '$lib/server/mock/mode';
import { openDemoContext, readSessionId, runWithDemoSession } from '$lib/server/mock/session';

export const handle: Handle = async ({ event, resolve }) => {
	event.params.lang ??= defaultLocale;
	const respond = () =>
		resolve(event, {
			transformPageChunk: ({ html }) => html.replace('%lang%', checkUrlLocale(event))
		});
	if (!useMockData()) return respond();
	const sessionId = readSessionId(event.cookies);
	event.locals.demoSessionId = sessionId;
	const secure = event.url.protocol === 'https:';
	const context = await openDemoContext(sessionId, { cookies: event.cookies, secure });
	const response = await runWithDemoSession(context, async () => respond());
	if (sessionId) {
		response.headers.set('cache-control', 'private, no-store');
	}
	return response;
};

SentryNode.init({
	dsn: 'https://c2838269ac4d4b72995864bb70794bab@o740081.ingest.sentry.io/4504873190424576',
	tracesSampleRate: 0.01,
	// Add the Http integration for tracing
	integrations: [
		new SentryNode.Integrations.Http(),
		...(useMockData() ? [] : [new SentryNode.Integrations.Prisma(prisma)])
	],
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
		return;
	}
	return {
		message: error?.stack ?? error?.message
	};
}) satisfies HandleServerError;
