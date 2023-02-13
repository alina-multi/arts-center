import type {PageServerLoad} from './$types';
import {indexQuery} from "../../database/repositories/gallery";
import {worksPreviewMap} from "../../database/mappers/gallery";
export const load = (async ({params}) => {
    const gallery = worksPreviewMap(await indexQuery())
    return {
        gallery
    };
}) satisfies PageServerLoad;