import { usersMap } from '$lib/server/mappers/users';
import { query } from '$lib/server/repositories/user';
import type { PageServerLoad } from './$types';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { userCountries } from '$lib/server/repositories/user';
import { userCountriesMap } from '$lib/server/mappers/users';
import { titleToId } from '$lib/server/repositories/tag';
import { filteredQuery } from '$lib/server/repositories/user';
import { locale } from '$lib/translations';

export const load = (async ({ params }) => {
	params = {
		order: 'popular',
		category: 'all',
		country: 'all',
		...params
	};
	return Promise.all([
		usersMap(await filteredQuery(params.category, params.country, params.order, locale.get(), 0)),
		getCategories().then((categories) => tagsMap(categories)),
		userCountries().then((countries) => userCountriesMap(countries))
	]).then((values) => {
		return {
			users: values[0],
			categories: values[1],
			countries: values[2],
			params
		};
	});
}) satisfies PageServerLoad;
