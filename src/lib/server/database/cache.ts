import NodeCache from 'node-cache';
import { createClient } from 'redis';
import type { RequestEvent } from '@sveltejs/kit';
import { api } from '$lib/server/api';
import * as devalue from 'devalue';

let cache;
if (process.env?.REDIS_URL) {
	cache = createClient({
		url: process.env.REDIS_URL
	});
	await cache.on('error', err => console.log('Redis Client Error', err))
		.connect();
} else {
	cache = new NodeCache();
}


export async function cacheGet(
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const value = await cache.get(key);
	if (value) {
		return devalue.parse(value);
	}
	return await cacheReplace(key, storeFunction, ttl);
}

export async function cacheReplace(
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const result = await storeFunction();
	cache.set(key, devalue.stringify(result), ttl);
	return result;
}

export async function cacheClear(key) {
	await cache.del(key);
}

export async function reloadCurrentUser(event: RequestEvent) {
	const session = event?.cookies?.get('laravel_session');
	return event.locals.user = await cacheReplace(
		`frontend.${session}`,
		async () => {
			const response = await api({ method: 'GET', path: '/api2/me', event });
			if (response.ok) {
				return await response.json();
			}
		},
		360
	);
}
