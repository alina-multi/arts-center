import type { Handle } from '@sveltejs/kit';
import { locale } from '$lib/translations';
//
// export const handle = (async ({ event, resolve }) => {
//     locale.set('en')
//     if (event.url.pathname.startsWith('/de/')) {
//         event.url.pathname = event.url.pathname.replace('/de/', '/');
//         console.log(event.url.pathname)
//         locale.set('de')
//     }
//
//     const response = await resolve(event,{
//         transformPageChunk: ({ html }) => html.replace(/<html.*>/, `<html lang="${locale.get()}">`),
//     });
//     return response;
// }) satisfies Handle;