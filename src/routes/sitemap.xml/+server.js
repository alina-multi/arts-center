import { prisma } from '$lib/server/database/prisma';

const site = 'http://localhost:3000/sitemap.xml';
const urlsPerSitemap = 10;

export async function GET() {
	const countWorks = await prisma.works.count();
	const pagesWorks = Math.ceil(countWorks / urlsPerSitemap);

	const countUsers = await prisma.users.count();
	const pagesUsers = Math.ceil(countUsers / urlsPerSitemap);

	const worksArray = Array.from(Array(pagesWorks).keys());
	const usersArray = Array.from(Array(pagesUsers).keys());

	const body = sitemapindex(worksArray, usersArray);
	const response = new Response(body);
	response.headers.set('Cache-Control', 'max-age=0, s-maxage=3600');
	response.headers.set('Content-Type', 'application/xml');
	return response;
}

function sitemapindex(works, users) {
	return (
		`<?xml version="1.0" encoding="UTF-8"?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">` +
		works
			.map((page) => {
				return `<sitemap>
        <loc>${site}/sitemap-works/${page}.xml</loc>
        <lastmod>${new Date().toISOString()}</lastmod>
    </sitemap>`;
			})
			.join('') +
		users
			.map((page) => {
				return `<sitemap>
        <loc>${site}/sitemap-users/${page}.xml</loc>
        <lastmod>${new Date().toISOString()}</lastmod>
    </sitemap>`;
			})
			.join('') +
		`</sitemapindex>`
	);
}
