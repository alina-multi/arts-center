import { prisma } from '$lib/server/database/prisma';
import { sitemapAllLanguages, urlsetResponse } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';
import { cacheGet } from '$lib/server/database/cache';
import { useMockData } from '$lib/server/mock/mode';
import { mockWorks } from '$lib/server/mock/data';

export async function GET({ params, url }) {
	const base = url.origin;
	const body = await cacheGet(
		'sitemap',
		`wroks2.${params.page}`,
		async function () {
			if (useMockData()) {
				const page = Number(params.page) || 0;
				const works = mockWorks
					.filter((work) => work.published_at && work.status >= 40)
					.sort((left, right) => (left.id < right.id ? -1 : 1))
					.slice(page * urlsPerSitemap, page * urlsPerSitemap + urlsPerSitemap)
					.map((work) => ({ id: work.id, updated_at: work.updated_at }));
				return sitemapAllLanguages(works, base, 'id', 'work');
			}
			const works = await prisma.works.findMany({
				take: urlsPerSitemap,
				skip: params.page * urlsPerSitemap,
				where: {
					NOT: {
						published_at: null
					},
					status: { gte: 40 }
				},
				select: {
					id: true,
					updated_at: true
				},
				orderBy: { id: 'asc' }
			});

			return sitemapAllLanguages(works, base, 'id', 'work');
		},
		params.page <= 15 ? 60 * 60 * 24 : 60 // Hardcode last page to have small TTL cache
	);
	return urlsetResponse(body);
}
