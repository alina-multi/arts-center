import type { ParamMatcher } from '@sveltejs/kit';

const excluded = ['uk'];

export const match = ((param) => {
	if (excluded.includes(param)) return false;
	return /^[a-zA-Z0-9-_]+$/.test(param);
}) satisfies ParamMatcher;
