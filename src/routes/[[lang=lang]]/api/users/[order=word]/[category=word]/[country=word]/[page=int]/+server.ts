import type { RequestHandler } from './$types';
import { locale } from '$lib/translations';
import { filteredQuery } from '$lib/server/repositories/user';
import { usersMap } from '$lib/server/mappers/users';
import * as devalue from 'devalue';

export const GET = (async ({ params }) => {
	console.log(
		await filteredQuery(params.category, params.country, params.order, locale.get(), params.page)
	);
	return new Response(
		devalue.stringify({
			users: await usersMap(
				await filteredQuery(
					params.category,
					params.country,
					params.order,
					locale.get(),
					params.page
				)
			)
		})
	);
}) satisfies RequestHandler;
