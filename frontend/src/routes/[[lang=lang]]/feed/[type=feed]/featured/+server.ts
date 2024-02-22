import { Feed } from 'feed';
import { loadTranslations } from '$lib/translations';
import { prisma } from '$lib/server/database/prisma';
import { imageSelect } from '$lib/server/repositories/image';
import { pictureMap } from '$lib/server/mappers/pictures';
import { userSelect } from '$lib/server/repositories/user';

export async function GET({ params, url }) {
	const { t } = await loadTranslations(params.lang, url.pathname);
	const localeSiteUrl = `${url.origin}${params.lang !== 'en' ? `/${params.lang}` : ''}`;
	const feed = new Feed({
		id: localeSiteUrl,
		link: localeSiteUrl,
		favicon: 'https://arts.center/favicon/favicon-96x96.png',
		copyright: `All rights reserved ${new Date().getFullYear()}, Arts center online inc.`,
		title: t.get('global.seo.title.index'),
		description: t.get('global.seo.description.index'),
		language: params.lang
	});

	const posts = await prisma.posts.findMany({
		take: 100,
		where: {
			NOT: { published_at: null },
			featured: 1,
			language: params.lang
		},
		select: {
			id: true,
			title: true,
			published_at: true,
			body: true,
			image: imageSelect,
			owner: {
				select: userSelect
			}
		},
		orderBy: { published_at: 'desc' }
	});

	for (const post of posts) {
		const postUrl = `${url.origin}/${params.lang !== 'en' ? `${params.lang}/` : ''}post/${post.id}`;
		const userUrl = `${url.origin}/${params.lang !== 'en' ? `${params.lang}/` : ''}${
			post.owner.username
		}`;
		feed.addItem({
			id: postUrl,
			link: postUrl,
			title: post.title,
			date: post.published_at,
			author: [
				{
					name: post?.owner?.name,
					link: userUrl
				}
			],
			content: post?.body[0]?.text,
			image: post?.image ? pictureMap(post?.image)?.original?.src : undefined
		});
	}

	const body = params.type === 'atom' ? feed.atom1() : feed.rss2();

	const response = new Response(body);
	response.headers.set('Cache-Control', 'max-age=0, s-maxage=3600');
	response.headers.set('Content-Type', 'application/xml');
	return response;
}
