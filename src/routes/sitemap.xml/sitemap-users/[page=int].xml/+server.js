import { prisma } from '$lib/server/database/prisma';
import { sitemap, createXml } from '$lib/helpers/sitemap';

const url = 'http://localhost:3000/';
const urlsPerSitemap = 10000;

export async function GET({ params }) {
	const users = await prisma.users.findMany({
		take: urlsPerSitemap,
		skip: params.page * urlsPerSitemap,
		select: {
			username: true,
			updated_at: true
		}
	});
	const body = sitemap(users, url, 'username');
	const res = createXml(body);
	return res;
}
