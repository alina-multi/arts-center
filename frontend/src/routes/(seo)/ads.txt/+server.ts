import { cacheGet } from '$lib/server/database/cache';

export async function GET() {
	const content = await cacheGet(
		'page',
		'ads.txt',
		async () => (await fetch('https://srv.adstxtmanager.com/19390/arts.center')).text(),
		3600
	);

	return new Response(content as string, {
		headers: { 'Content-Type': 'text/plain; charset=utf-8' }
	});
}
