import type {PageServerLoad} from './$types';
import {query} from '$lib/server/repositories/user';
import {usersMap} from '$lib/server/mappers/users';
import {query as postQuery} from '$lib/server/repositories/post'
import {postsMap} from "$lib/server/mappers/post";

export const load = (async ({setHeaders, params}) => {
    setHeaders({
        'cache-control': 'max-age=60'
    });

    const [users, posts] = await Promise.all([
        query(
            {verified_at: {not: null}},
            {verified_at: 'desc'})
            .then((usersRaw) => usersMap(usersRaw, params.lang)),
        postQuery(
            {featured: 1, language: params.lang},
            {published_at: 'desc'})
            .then((postsRaw) => postsMap(postsRaw))
    ])

    return {
        users,
        posts
    };
}) satisfies PageServerLoad;
