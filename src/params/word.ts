import type { ParamMatcher } from '@sveltejs/kit';

export const match = ((param) => {
	return /^[\wабвгґдеєжзиіїйклмнопрстуфхцчшщьюя]+$/iu.test(param);
}) satisfies ParamMatcher;
