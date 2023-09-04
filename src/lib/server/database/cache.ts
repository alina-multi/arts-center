import NodeCache from 'node-cache';

const cache = new NodeCache();

export async function cacheGet(
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const value = cache.get(key);
	if (value) {
		return value;
	}
	return cacheReplace(key, storeFunction, ttl);
}

export async function cacheReplace(
	key: string,
	storeFunction: () => Promise<object | string>,
	ttl = 120
) {
	const result = await storeFunction();
	cache.set(key, result, ttl);
	return result;
}
