import { prisma } from '$lib/server/database/prisma';
import { sitemap, createXml } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';
import { cacheGet } from '$lib/server/database/cache';

export async function GET({ params, url }) {
	const base = url.origin;
	const body = await cacheGet(
		'sitemap',
		`wroks.${params.page}`,
		async function () {
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

			return sitemap(works, base, 'id', 'work');
		},
		params.page <= 15 ? 60 * 60 * 24 : 60 // Hardcode last page to have small TTL cache
	);
	return createXml(body);
}
