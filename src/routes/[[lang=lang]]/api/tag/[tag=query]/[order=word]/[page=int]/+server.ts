import type { RequestHandler } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { stringify } from 'devalue';
import { unslug } from '$lib/helpers/url';

export const GET = (async ({ params, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	return new Response(
		stringify({
			gallery: await filteredQuery(unslug(params.tag), params.lang, params.order, params.page).then(
				(works) => worksPreviewMap(works)
			)
		})
	);
}) satisfies RequestHandler;
