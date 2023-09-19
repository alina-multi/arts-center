import type { RequestHandler } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';
import * as devalue from 'devalue';

export const GET = (async ({ params, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	return new Response(
		devalue.stringify({
			gallery: await filteredQuery(
				params.tag.replaceAll('_', ' '),
				locale.get(),
				params.order,
				params.page
			).then((works) => worksPreviewMap(works))
		})
	);
}) satisfies RequestHandler;
