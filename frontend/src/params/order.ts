import type { ParamMatcher } from '@sveltejs/kit';

export const match = ((param) => {
	return ['new', 'popular', 'trending', 'rising'].includes(param);
}) satisfies ParamMatcher;
