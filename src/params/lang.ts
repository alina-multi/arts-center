import type {ParamMatcher} from "@sveltejs/kit";
import {correctLocale} from "$lib/translations";

export const match = ((param) => {
    return param.length === 2
        && param !== "en" // en is the default locale and should not be in the URL
        && correctLocale(param);
}) satisfies ParamMatcher;