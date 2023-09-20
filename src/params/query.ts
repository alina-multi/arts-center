import type { ParamMatcher } from '@sveltejs/kit';

export const match = ((param) => {
	return /^[a-zA-Z0-9А-ЩЬЮЯҐЄІЇИа-щьюяґєіїи_]+$/.test(param);
}) satisfies ParamMatcher;
