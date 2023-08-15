import { prisma } from '$lib/server/database/prisma';

const site = 'http://localhost:3000';
const urlsPerSitemap = 10;

export async function GET({ params }) {
	let page = params.page;
	const works = await prisma.works.findMany({
		take: urlsPerSitemap,
		skip: page * urlsPerSitemap,
		select: {
			id: true,
			updated_at: true
		}
	});

	const body = sitemap(works);
	const response = new Response(body);
	response.headers.set('Cache-Control', 'max-age=0, s-maxage=3600');
	response.headers.set('Content-Type', 'application/xml');
	return response;
}

function sitemap(works) {
	return `<?xml version="1.0" encoding="UTF-8" ?>
    <urlset 
    xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:news="https://www.google.com/schemas/sitemap-news/0.9"
    xmlns:xhtml="https://www.w3.org/1999/xhtml"
    xmlns:mobile="https://www.google.com/schemas/sitemap-mobile/1.0"
    xmlns:image="https://www.google.com/schemas/sitemap-image/1.1">

    ${works
			.map((work) => {
				return `
        <url>

            <loc>${site}/work/${work.id}</loc>
            <lastmod>${work.updated_at}</lastmod>
        </url>
        `;
			})
			.join('')}
    </urlset>
    `;
}
