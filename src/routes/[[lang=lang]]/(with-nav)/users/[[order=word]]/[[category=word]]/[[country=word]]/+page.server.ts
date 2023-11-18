import { usersMap, userCountriesMap } from '$lib/server/mappers/users';
import type { PageServerLoad } from './$types';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { userCountries } from '$lib/server/repositories/user';
import { filteredQuery } from '$lib/server/repositories/user';
import { unslug } from '$lib/helpers/url';

export const load = (async ({ params, url, setHeaders }) => {
	setHeaders({
		'cache-control': 'max-age=600'
	});
	params.order ??= 'popular';
	params.category ??= 'all';
	params.country ??= 'all';
	// This is here just to let SvelteKit know to invalidate the page when the pathname changes
	url.pathname;
	const [users, categories, countries] = await Promise.all([
		filteredQuery(unslug(params.category), params.country, params.order, params.lang, 1),
		getCategories(),
		userCountries()
	]);
	return {
		users: usersMap(users, params.lang),
		categories: tagsMap(categories, params.lang),
		countries: userCountriesMap(countries, params.lang),
		params
	};
}) satisfies PageServerLoad;
