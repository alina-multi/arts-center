import type {PageServerLoad} from './$types';
import {indexQuery} from "../../prisma/repositories/gallery";
export const load = (async ({params}) => {
    return {
        gallery: await indexQuery()
    };
}) satisfies PageServerLoad;