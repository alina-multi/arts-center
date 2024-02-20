import type { ParamMatcher } from '@sveltejs/kit';

export const match = ((param) => {
	return ['atom', 'rss'].includes(param);
}) satisfies ParamMatcher;
