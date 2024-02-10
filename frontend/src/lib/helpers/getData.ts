export async function getData(url: string) {
	const response = await fetch(url);
	const result = await response.json();
	return result;
}
