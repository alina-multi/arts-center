import { prisma } from '$lib/server/database/prisma';
import { sitemapEntityLanguage, urlsetResponse } from '$lib/helpers/sitemap';
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
	const body = sitemapEntityLanguage(posts, base, 'id', 'post', '0.9');
	return urlsetResponse(body);
}
