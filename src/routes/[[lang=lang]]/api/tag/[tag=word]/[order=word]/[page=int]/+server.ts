import type { RequestHandler } from './$types';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { filteredQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';
import * as devalue from 'devalue';

export const GET = (async ({ params }) => {
	return new Response(
		devalue.stringify({
			gallery: await filteredQuery(params.tag, locale.get(), params.order, params.page).then(
				(works) => worksPreviewMap(works)
			)
		})
	);
}) satisfies RequestHandler;
