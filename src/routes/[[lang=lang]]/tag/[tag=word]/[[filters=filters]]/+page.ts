import type {PageLoad} from './$types';

export const load = (({ params }) => {
    return {
        tag: params.tag,
        filters: params.filters || [],
    };
}) satisfies PageLoad;