export async function convertFetch(fetchPromise) {
	const res = await fetchPromise;
	if (!res.ok) {
		throw res;
	}
	return res;
}
