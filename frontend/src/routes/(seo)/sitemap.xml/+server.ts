import { prisma } from '$lib/server/database/prisma';
import { createXmlResponse } from '$lib/helpers/sitemap';
import { useMockData } from '$lib/server/mock/mode';
import { mockPosts, mockUsers, mockWorks } from '$lib/server/mock/data';

import { urlsPerSitemap } from '../config';

let site = '';
function createPagesArray(count: number) {
	const elements = Math.ceil(count / urlsPerSitemap);
	const array = Array.from(Array(elements).keys());

	return array;
}

export async function GET({ url }) {
	site = url.origin;
	if (useMockData()) {
		const works = mockWorks.filter((work) => work.status >= 40).length;
		const users = mockUsers.length;
		const posts = mockPosts.filter((post) => post.published_at).length;
		const body = sitemapindex([
			{ pages: createPagesArray(works), slug: 'works' },
			{ pages: createPagesArray(users), slug: 'users' },
			{ pages: createPagesArray(posts), slug: 'posts' }
		]);
		return createXmlResponse(body);
	}
	const works = await prisma.works.count({
		where: {
			status: { gte: 40 }
		}
	});
	const users = await prisma.users.count();
	const posts = await prisma.posts.count({
		where: {
			NOT: {
				published_at: null
			}
		}
	});

	const body = sitemapindex([
		{ pages: createPagesArray(works), slug: 'works' },
		{ pages: createPagesArray(users), slug: 'users' },
		// Todo: fix this when we have >50k posts :D
		{ pages: createPagesArray(posts), slug: 'posts' }
	]);

	const response = createXmlResponse(body);
	return response;
}

function sitemapindex(entity) {
	let string = `<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">`;
	for (const item of entity) {
		for (const page of item.pages) {
			string += `
	<sitemap>
		<loc>${site}/sitemap-${item.slug}-${page}.xml</loc>
	</sitemap>`;
		}
	}
	string += `
</sitemapindex>`;
	return string;
}
