import type { ParamMatcher } from '@sveltejs/kit';

export const match = ((param) => {
	return param === 'users' || param === 'works' || param === 'all';
}) satisfies ParamMatcher;
