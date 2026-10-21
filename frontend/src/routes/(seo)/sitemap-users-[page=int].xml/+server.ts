import { prisma } from '$lib/server/database/prisma';
import { sitemapAllLanguages, urlsetResponse } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';
import { cacheGet } from '$lib/server/database/cache';
import { useMockData } from '$lib/server/mock/mode';
import { mockUsers } from '$lib/server/mock/data';

export async function GET({ params, url }) {
	const base = url.origin;
	const body = await cacheGet(
		'sitemap',
		`users2.${params.page}`,
		async function () {
			if (useMockData()) {
				const page = Number(params.page) || 0;
				const users = [...mockUsers]
					.sort((left, right) => (left.id < right.id ? -1 : 1))
					.slice(page * urlsPerSitemap, page * urlsPerSitemap + urlsPerSitemap)
					.map((user) => ({ username: user.username, updated_at: user.updated_at }));
				return sitemapAllLanguages(users, base, 'username', null, '0.7');
			}
			const users = await prisma.users.findMany({
				take: urlsPerSitemap,
				skip: params.page * urlsPerSitemap,

				select: {
					username: true,
					updated_at: true
				},
				orderBy: { id: 'asc' }
			});
			return sitemapAllLanguages(users, base, 'username', null, '0.7');
		},
		60
	);
	return urlsetResponse(body);
}
