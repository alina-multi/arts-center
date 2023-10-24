import type { PageServerLoad } from './$types';
import { fetchData } from '$lib/helpers/fetchData';
import { api } from '$lib/server/api';
import { defaultLocale, locale } from '$lib/translations';

export const load = (async (event) => {
	const response = await api({
		method: 'GET',
		path: `/api2/checkout/${event.url.searchParams.get('session_id')}`,
		event
	})
	return await response.json();
}) satisfies PageServerLoad;