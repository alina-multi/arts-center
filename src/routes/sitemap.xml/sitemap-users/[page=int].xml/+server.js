import { prisma } from '$lib/server/database/prisma';
import { createXml } from '$lib/helpers/sitemap';

const url = 'http://localhost:3000/';
const urlsPerSitemap = 10;

export async function GET({ params }) {
	let page = params.page;

	const users = await prisma.users.findMany({
		take: urlsPerSitemap,
		skip: page * urlsPerSitemap,
		select: {
			username: true,
			updated_at: true
		}
	});

	const res = createXml(users, url, 'username');

	return res;
}
