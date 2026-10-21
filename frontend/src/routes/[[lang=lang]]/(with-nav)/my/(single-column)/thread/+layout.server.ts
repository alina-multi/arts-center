import type { LayoutServerLoad } from './$types';
import { api } from '$lib/server/api';
import { useMockData } from '$lib/server/mock/mode';
import { listDemoThreads } from '$lib/server/mock/actions';

export const load = (async (event) => {
	if (useMockData()) return { threads: listDemoThreads() };
	const response = await api({ method: 'GET', path: '/api2/thread', event });
	const threads = await response.json();

	return { threads };
}) satisfies LayoutServerLoad;
