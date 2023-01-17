import type { Handle, HandleFetch } from '@sveltejs/kit';
import { locale } from '$lib/translations';

// export const handle = (async ({ event, resolve}) => {
//     locale.set('en')
//     console.log(event.route)
//     if (event.url.pathname.startsWith('/de/')) {
//         event.url.pathname = event.url.pathname.replace('/de/', '/');
//         locale.set('de')
//         event.route.id = '/about'
//     }
//
//     const response = await resolve(event,{
//         transformPageChunk: ({ html }) => html.replace(/<html.*>/, `<html lang="${locale}">`),
//     });
//     return response;
// }) satisfies Handle;