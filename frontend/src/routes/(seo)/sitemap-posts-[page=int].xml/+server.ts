import { prisma } from '$lib/server/database/prisma';
import { createXml, sitemapEntityLanguage } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';
import { cacheGet } from '$lib/server/database/cache';

export async function GET({ params, url }) {
	const base = url.origin;
	const body = await cacheGet(
		'sitemap',
		`posts335.${params.page}`,
		async function () {
			const posts = await prisma.posts.findMany({
				take: urlsPerSitemap,
				skip: params.page * urlsPerSitemap,
				where: {
					NOT: {
						published_at: null
					}
				},
				select: {
					id: true,
					language: true,
					updated_at: true
				},
				orderBy: { id: 'asc' }
			});

			return sitemapEntityLanguage(posts, base, 'id', 'post');
		},
		params.page <= 15 ? 60 * 60 * 24 : 60 // Hardcode last page to have small TTL cache
	);
	return createXml(body);
}
