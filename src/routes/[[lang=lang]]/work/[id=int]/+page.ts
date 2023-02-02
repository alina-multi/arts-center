import type {PageLoad} from './$types';

export const load = (({ params }) => {
    return {
        work: {
            id: params.id,
        }
    };
}) satisfies PageLoad;