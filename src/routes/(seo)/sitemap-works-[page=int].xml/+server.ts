import { prisma } from '$lib/server/database/prisma';
import { sitemap, createXml } from '$lib/helpers/sitemap';

const urlsPerSitemap = 10000;

export async function GET({ params, url }) {
	const base  = url.origin;
	const works = await prisma.works.findMany({
		take: urlsPerSitemap,
		skip: params.page * urlsPerSitemap,
		where: {
			NOT: {
				published_at: null
			}
		},
		select: {
			id: true,
			updated_at: true
		},
		orderBy: {id: 'asc'}
	});

	const body = sitemap(works, base, 'id', 'work');
	const res = createXml(body);

	return res;
}
