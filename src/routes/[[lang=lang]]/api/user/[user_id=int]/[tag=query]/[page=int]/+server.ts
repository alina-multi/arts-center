import type { RequestHandler } from './$types';
import * as devalue from 'devalue';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userQuery } from '$lib/server/repositories/gallery';
import { locale } from '$lib/translations';

export const GET = (async ({ params }) => {
	const lang = locale.get() ?? 'en';
	return new Response(
		devalue.stringify({
			gallery: await worksPreviewMap(await userQuery(params.user_id, params.tag, lang, params.page))
		})
	);
}) satisfies RequestHandler;
