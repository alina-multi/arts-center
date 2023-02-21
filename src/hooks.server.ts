import type { Handle } from '@sveltejs/kit';
import { checkUrlLocale } from '$lib/translations';

export const handle = (({ event, resolve }) => {
	return resolve(event, {
		transformPageChunk: ({ html }) => html.replace('%lang%', checkUrlLocale(event))
	});
}) satisfies Handle;
