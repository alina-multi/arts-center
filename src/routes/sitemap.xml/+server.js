import { prisma } from '$lib/server/database/prisma';
import { createXml } from '$lib/helpers/sitemap';

const site = 'http://localhost:3000/sitemap.xml';
const urlsPerSitemap = 10000;

function createPagesArray(entity) {
	let count = Math.ceil(entity / urlsPerSitemap);
	let array = Array.from(Array(count).keys());
	return array;
}

export async function GET() {
	const works = await prisma.works.count();
	const users = await prisma.users.count();

	const body = sitemapindex([
		{ pages: createPagesArray(works), slug: 'works' },
		{ pages: createPagesArray(users), slug: 'users' }
	]);

	const response = createXml(body);
	return response;
}

function sitemapindex(entity) {
	return (
		`<?xml version="1.0" encoding="UTF-8"?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">` +
		entity.map((items) => {
			return items.pages
				.map((page) => {
					return `<sitemap>
        <loc>${site}/sitemap-${items.slug}/${page}.xml</loc>
    </sitemap>`;
				})
				.join('');
		}) +
		`</sitemapindex>`
	);
}
