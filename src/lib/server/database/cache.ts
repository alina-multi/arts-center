import NodeCache from 'node-cache';
import { createClient } from 'redis';
import type { RequestEvent } from '@sveltejs/kit';
import type { RedisClientType } from 'redis';
import { api } from '$lib/server/api';
import { parse, stringify } from 'devalue';

let cache: NodeCache | RedisClientType;

type cacheNamespace = 'work' | 'user' | 'auth' | 'page' | 'gallery' | 'search' | 'sitemap';

if (process.env?.REDIS_URL) {
	cache = createClient({
		url: `${process.env.REDIS_URL}/2`
	});
	await cache.on('error', (err) => console.log('Redis Client Error', err)).connect();
} else {
	cache = new NodeCache();
}

export async function cacheGet(
	namespace: cacheNamespace,
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const value = await cache.get(buildKey(namespace, key));
	if (value) {
		return parse(value);
	}
	return await cacheReplace(namespace, key, storeFunction, ttl);
}

export async function cacheReplace(
	namespace: cacheNamespace,
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const result = await storeFunction();
	if (result !== undefined) {
		cache.set(
			buildKey(namespace, key),
			stringify(result),
			process.env?.REDIS_URL ? { EX: ttl } : ttl
		);
	}
	return result;
}

export async function cacheClear(namespace: cacheNamespace, key: string) {
	await cache.del(buildKey(namespace, key));
}

export async function reloadCurrentUser(event: RequestEvent) {
	const session = event?.cookies?.get('laravel_session');
	if (session) {
		return await cacheReplace(
			'auth',
			session,
			async () => {
				const response = await api({ method: 'GET', path: '/api2/me', event });
				if (response.ok) {
					return await response.json();
				}
			},
			360
		);
	}
}

function buildKey(namespace: cacheNamespace, key: string) {
	return `frontend.${namespace}.${key}`;
}
