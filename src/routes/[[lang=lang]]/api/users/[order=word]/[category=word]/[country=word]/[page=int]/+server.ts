import type { RequestHandler } from './$types';
import { locale } from '$lib/translations';
import { filteredQuery } from '$lib/server/repositories/user';
import { usersMap } from '$lib/server/mappers/users';
import * as devalue from 'devalue';
import { unslug } from '$lib/helpers/url';

export const GET = (async ({ params }) => {
	return new Response(
		devalue.stringify({
			users: await usersMap(
				await filteredQuery(
					unslug(params.category),
					params.country,
					params.order,
					locale.get() ?? 'en',
					params.page
				)
			)
		})
	);
}) satisfies RequestHandler;
