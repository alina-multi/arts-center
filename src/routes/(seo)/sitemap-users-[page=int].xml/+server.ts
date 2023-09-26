import { prisma } from '$lib/server/database/prisma';
import { sitemap, createXml } from '$lib/helpers/sitemap';
import { urlsPerSitemap } from '../config';
import { cacheGet } from '$lib/server/database/cache';

export async function GET({ params, url }) {
	const base = url.origin;
	const body = await cacheGet(
		'sitemap',
		`users.${params.page}`,
		async function () {
			const users = await prisma.users.findMany({
				take: urlsPerSitemap,
				skip: params.page * urlsPerSitemap,

				select: {
					username: true,
					updated_at: true
				},
				orderBy: { id: 'asc' }
			});
			return sitemap(users, base, 'username');
		},
		60
	)
	return createXml(body);
}
