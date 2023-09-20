import NodeCache from 'node-cache';
import { createClient } from 'redis';
import type { RequestEvent } from '@sveltejs/kit';
import { api } from '$lib/server/api';
import * as devalue from 'devalue';

let cache;

type cacheNemespace = 'work' | 'user' | 'auth' | 'page' | 'gallery' | 'search';

if (process.env?.REDIS_URL) {
	cache = createClient({
		url: `${process.env.REDIS_URL}/2`
	});
	await cache.on('error', (err) => console.log('Redis Client Error', err)).connect();
} else {
	cache = new NodeCache();
}

export async function cacheGet(
	namespace: cacheNemespace,
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const value = await cache.get(buildKey(namespace, key));
	if (value) {
		return devalue.parse(value);
	}
	return await cacheReplace(namespace, key, storeFunction, ttl);
}

export async function cacheReplace(
	namespace: cacheNemespace,
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const result = await storeFunction();
	cache.set(buildKey(namespace, key), devalue.stringify(result), ttl);
	return result;
}

export async function cacheClear(namespace: cacheNemespace, key: string) {
	await cache.del(buildKey(namespace, key));
}

export async function reloadCurrentUser(event: RequestEvent) {
	const session = event?.cookies?.get('laravel_session');
	if (session) {
		return (event.locals.user = await cacheReplace(
			'auth',
			session,
			async () => {
				const response = await api({ method: 'GET', path: '/api2/me', event });
				if (response.ok) {
					return await response.json();
				}
			},
			360
		));
	}
}

function buildKey(namespace: cacheNemespace, key: string) {
	return `frontend.${namespace}.${key}`;
}
