import type { ParamMatcher } from '@sveltejs/kit';

export const match = ((param) => {
	return param === 'new' || param === 'sale';
}) satisfies ParamMatcher;
