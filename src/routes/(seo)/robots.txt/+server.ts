import { env } from '$env/dynamic/public';

const robots_prod = `
User-agent: *
Disallow: /my/
Allow: /
Sitemap: https://arts.center/sitemap.xml
`;

const robots_other = `
User-agent: *
Disallow: /
`;

export async function GET() {
	return new Response(env.PUBLIC_ENV === 'production' ? robots_prod : robots_other);
}
