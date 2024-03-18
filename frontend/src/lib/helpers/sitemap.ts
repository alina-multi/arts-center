import { availableLocales } from '$lib/translations';

export function createXmlResponse(content: string) {
	const body = `<?xml version="1.0" encoding="UTF-8" ?>
${content}`;
	const response = new Response(body);
	response.headers.set('Cache-Control', 'max-age=0, s-maxage=3600');
	response.headers.set('Content-Type', 'application/xml');
	return response;
}

export function urlsetResponse(urlset: string) {
	return createXmlResponse(`<urlset
	xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:news="https://www.google.com/schemas/sitemap-news/0.9"
	xmlns:xhtml="https://www.w3.org/1999/xhtml"
	xmlns:mobile="https://www.google.com/schemas/sitemap-mobile/1.0"
	xmlns:image="https://www.google.com/schemas/sitemap-image/1.1">
		${urlset}
		</urlset>`);
}

export function sitemapAllLanguages(entity, site, key, slug = null, priority = '0.5') {
	let urlset = '';
	for (const item of entity) {
		for (const lang of availableLocales) {
			urlset += url(
				`${site}/${lang !== 'en' ? `${lang}/` : ''}${slug ? `${slug}/` : ''}${item[key]}`,
				item.updated_at,
				priority
			);
		}
	}
	return urlset;
}

export function sitemapEntityLanguage(entity, site, key, slug = null, priority = '0.5') {
	let urlset = '';
	for (const item of entity) {
		urlset += url(
			`${site}/${item.language !== 'en' ? `${item.language}/` : ''}${slug ? `${slug}/` : ''}${
				item[key]
			}`,
			item.updated_at,
			priority
		);
	}
	return urlset;
}

export function url(loc: string, lastmod: Date, priority = '0.5') {
	return `
	<url>
		<loc>${loc}</loc>
		<lastmod>${lastmod.toISOString()}</lastmod>
		<priority>${priority}</priority>
	</url>`;
}
