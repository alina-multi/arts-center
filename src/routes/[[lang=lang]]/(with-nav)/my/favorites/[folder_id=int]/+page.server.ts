import type { PageServerLoad } from './$types';
import {api} from '$lib/server/api';



export const load = (async ( event) => {
    const folder_id = Number(event.params.folder_id);
    if (folder_id === 0) {
        return {favorites: []};
    }

    const response = await api({method: 'GET', path: `/api2/favorite-folder/${event.params.folder_id}`, event});
    const favorites = await response.json();

    return {
        favorites
    };
}) satisfies PageServerLoad;