import NodeCache from "node-cache";

const cache = new NodeCache();

export async function cacheGet(key: string, storeFunction: Function, ttl = 120) {
  const value = cache.get(key);
  if (value) {
    return value;
  }
  const result = await storeFunction();
  cache.set(key, result, ttl);
  return result;
}