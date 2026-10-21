import type { LayoutServerLoad } from './$types';
import { useMockData } from '$lib/server/mock/mode';

export const load = (() => {
	return { demo: useMockData() };
}) satisfies LayoutServerLoad;
