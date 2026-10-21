import { prisma } from '$lib/server/database/prisma';
import { sitemapEntityLanguage, urlsetResponse } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';
import { useMockData } from '$lib/server/mock/mode';
import { mockPosts } from '$lib/server/mock/data';

export async function GET({ params, url }) {
	const base = url.origin;
	if (useMockData()) {
		const page = Number(params.page) || 0;
		const posts = mockPosts
			.filter((post) => post.published_at)
			.sort((left, right) => (left.id < right.id ? -1 : 1))
			.slice(page * urlsPerSitemap, page * urlsPerSitemap + urlsPerSitemap)
			.map((post) => ({
				id: post.id,
				language: post.language,
				updated_at: post.updated_at
			}));
		return urlsetResponse(sitemapEntityLanguage(posts, base, 'id', 'post', '0.9'));
	}
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
