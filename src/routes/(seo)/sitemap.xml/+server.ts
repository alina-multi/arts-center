import { prisma } from '$lib/server/database/prisma';
import { createXml } from '$lib/helpers/sitemap';
import { locales } from '$lib/translations/index.js';

const urlsPerSitemap = 10000;
let site = '';
function createPagesArray(count: number) {
	let elements = Math.ceil(count / urlsPerSitemap);
	let array = Array.from(Array(elements).keys());
	return array;
}

export async function GET({url}) {
	site = url.origin;
	const works = await prisma.works.count() * locales.get().length;
	const users = await prisma.users.count() * locales.get().length;

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
        <loc>${site}/sitemap-${items.slug}-${page}.xml</loc>
    </sitemap>`;
				})
				.join('');
		}) +
		`</sitemapindex>`
	);
}
