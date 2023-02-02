import type {ParamMatcher} from "@sveltejs/kit";

export const match = ((param) => {
    return /^\w+$/.test(param);
}) satisfies ParamMatcher;