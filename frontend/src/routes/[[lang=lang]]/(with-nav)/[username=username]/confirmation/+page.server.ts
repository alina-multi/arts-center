import type { PageServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { getDemoState } from '$lib/server/mock/session';

export const load = (async (event) => {
	if (useMockData()) {
		return { customer_details: { email: getDemoState()?.account?.email || 'demo@arts.center' } };
	}
	const response = await api({
		method: 'GET',
		path: `/api2/checkout/${event.url.searchParams.get('session_id')}`,
		event
	});
	return await response.json();
}) satisfies PageServerLoad;
