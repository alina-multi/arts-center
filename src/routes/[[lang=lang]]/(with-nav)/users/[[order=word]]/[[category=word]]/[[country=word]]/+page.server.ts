import { usersMap, userCountriesMap } from '$lib/server/mappers/users';
import type { PageServerLoad } from './$types';
import { getCategories } from '$lib/server/repositories/tag';
import { tagsMap } from '$lib/server/mappers/tag';
import { userCountries } from '$lib/server/repositories/user';
import { filteredQuery } from '$lib/server/repositories/user';
import { locale } from '$lib/translations';

export const load = (async (event) => {
	const params = {
		order: 'popular',
		category: 'all',
		country: 'all',
		page: 1,
		...event.params
	};
	// This is here just to let SvelteKit know to invalidate the page when the pathname changes
	event.url.pathname;
	return Promise.all([
		usersMap(
			await filteredQuery(params.category, params.country, params.order, locale.get(), params.page)
		),
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
