import type { ParamMatcher } from '@sveltejs/kit';

const excluded = ['uk'];

export const match = ((param) => {
	if (excluded.includes(param)) return false;
	return /^[\wабвгґдеєжзиіїйклмнопрстуфхцчшщьюя.]+$/iu.test(param);
}) satisfies ParamMatcher;
