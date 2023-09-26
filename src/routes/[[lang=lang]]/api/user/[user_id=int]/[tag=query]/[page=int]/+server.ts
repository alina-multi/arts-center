import type { RequestHandler } from './$types';
import * as devalue from 'devalue';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userQuery } from '$lib/server/repositories/gallery';

export const GET = (async ({ params }) => {
	return new Response(
		devalue.stringify({
			gallery: await worksPreviewMap(
				await userQuery(params.user_id, params.tag, params.lang, params.page)
			)
		})
	);
}) satisfies RequestHandler;
