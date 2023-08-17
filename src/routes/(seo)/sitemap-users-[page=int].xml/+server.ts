import { prisma } from '$lib/server/database/prisma';
import { sitemap, createXml } from '$lib/helpers/sitemap';
import {urlsPerSitemap} from '../config'


export async function GET({ params, url }) {
	const base  = url.origin;
	const users = await prisma.users.findMany({
		take: urlsPerSitemap,
		skip: params.page * urlsPerSitemap,
		
		select: {
			username: true,
			updated_at: true
		},
		orderBy: {id: 'asc'}
	});
	const body = sitemap(users, base, 'username');
	const res = createXml(body);
	return res;
}
