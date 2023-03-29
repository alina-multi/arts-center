import * as SentrySvelte from '@sentry/svelte';
import { BrowserTracing } from '@sentry/tracing';
import type { HandleClientError } from '@sveltejs/kit';
import { PUBLIC_ENV } from "$env/static/public";

SentrySvelte.init({
	dsn: 'https://c2838269ac4d4b72995864bb70794bab@o740081.ingest.sentry.io/4504873190424576',
	integrations: [new BrowserTracing()],
	tracesSampleRate: 0.01,
	environment: PUBLIC_ENV ?? 'development'
});

SentrySvelte.setTag('svelteKit', 'browser');

// This will catch errors in `load` functions from `+page.ts` files
export const handleError = (({ error, event }) => {
	SentrySvelte.captureException(error, { contexts: { sveltekit: { event } } });

	return {
		message: error.message
	};
}) satisfies HandleClientError;
