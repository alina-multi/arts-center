import type {PageServerLoad} from './$types';
import {PrismaClient} from '@prisma/client'

const prisma = new PrismaClient();
export const load = (async ({params}) => {
    return {
        gallery: await prisma.works.findMany({
            where: {
                rating: {
                    gte: 20
                },
                published_at: {not: null},
            },
            orderBy: {
                published_at: 'desc'
            }
        })
    };
}) satisfies PageServerLoad;