import type { LayoutServerLoad } from './$types';
import { api } from '$lib/server/api';

export const load = (async (event) => {
	const response = await api({ method: 'GET', path: '/api2/thread', event });
	const threads = await response.json();

	return { threads };
}) satisfies LayoutServerLoad;
