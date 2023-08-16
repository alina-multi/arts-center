import { prisma } from '$lib/server/database/prisma';
import { sitemap, createXml } from '$lib/helpers/sitemap';

const url = 'http://localhost:3000/';
const urlsPerSitemap = 10;

export async function GET({ params }) {
	const works = await prisma.works.findMany({
		take: urlsPerSitemap,
		skip: params.page * urlsPerSitemap,
		select: {
			id: true,
			updated_at: true
		}
	});

	const body = sitemap(works, url, 'id', 'work');
	const res = createXml(body);

	return res;
}
