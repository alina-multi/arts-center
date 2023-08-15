import { prisma } from "$lib/server/database/prisma";

const site = "http://localhost:3000"

export async function GET() {
    let page = 0
    const works = await prisma.works.findMany({
        take: 50000,
        skip: page * 30000,
        select: {
            id: true,
            updated_at: true,
        }
    })

    const users = await prisma.users.findMany({
        take: 50000,
        skip: page * 30000,
        select: {
            username: true,
            updated_at: true,
        }
    })


    const body = sitemap(works, users);
    const response = new Response(body);
    response.headers.set('Cache-Control', 'max-age=0, s-maxage=3600');
    response.headers.set('Content-Type', 'application/xml');
    return response;

  }



function sitemap(works, users) {
    return `<?xml version="1.0" encoding="UTF-8" ?>
    <urlset 
    xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:news="https://www.google.com/schemas/sitemap-news/0.9"
    xmlns:xhtml="https://www.w3.org/1999/xhtml"
    xmlns:mobile="https://www.google.com/schemas/sitemap-mobile/1.0"
    xmlns:image="https://www.google.com/schemas/sitemap-image/1.1">

    ${works.map((work) => {
        return `
        <url>

            <loc>${site}/work/${work.id}</loc>
            <lastmod>${work.updated_at}</lastmod>
        </url>
        `;
    }).join("")}


    ${users.map((user) => {
        return `
        <url>

            <loc>${site}/${user.username}</loc>
            <lastmod>${user.updated_at}</lastmod>
        </url>
        `;
    }).join("")}

    </urlset>
    `;
}
