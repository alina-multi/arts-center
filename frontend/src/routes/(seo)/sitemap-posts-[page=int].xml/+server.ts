import { prisma } from '$lib/server/database/prisma';
import { createXml, sitemapEntityLanguage } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';

export async function GET({ params, url }) {
	const base = url.origin;
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
	const body = sitemapEntityLanguage(posts, base, 'id', 'post');
	return createXml(body);
}
