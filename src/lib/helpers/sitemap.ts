import { locales } from '$lib/translations';

export function createXml(body) {
	const response = new Response(body);
	response.headers.set('Cache-Control', 'max-age=0, s-maxage=3600');
	response.headers.set('Content-Type', 'application/xml');
	return response;
}

export function sitemap(entity, site, key, slug = null) {
	return `<?xml version="1.0" encoding="UTF-8" ?>
    <urlset 
    xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:news="https://www.google.com/schemas/sitemap-news/0.9"
    xmlns:xhtml="https://www.w3.org/1999/xhtml"
    xmlns:mobile="https://www.google.com/schemas/sitemap-mobile/1.0"
    xmlns:image="https://www.google.com/schemas/sitemap-image/1.1">
${entity
	.map((item) => {
		return locales.get().map((locale) => {
			return `
        <url>
            <loc>${site}/${locale !== 'en' ? `${locale}/` : ''}${slug ? `${slug}/` : ''}${
							item[key]
						}</loc>
            <lastmod>${item.updated_at.toISOString()}</lastmod>
        </url>
        `;
		});
	})
	.join('')}


    </urlset>
    `;
}
