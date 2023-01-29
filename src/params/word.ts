import type {ParamMatcher} from "@sveltejs/kit";

export const match = ((param) => {
    return /^[\wабвгґдеєжзиіїйклмнопрстуфхцчшщьюя]+$/ui.test(param);
}) satisfies ParamMatcher;


