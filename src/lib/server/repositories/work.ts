import { PrismaClient } from '@prisma/client';
import { userSelect } from './user';
import { imageSelect } from '$lib/server/repositories/image';

const prisma = new PrismaClient({
	log: [
		{
			emit: 'event',
			level: 'query'
		}
	]
});

const PAGE_SIZE = 20;

export function get(id: bigint) {
	return prisma.works.findUnique({
		select: {
			id: true,
			published_at: true,
			rating: true,
			comments: true,
			hosts: true,
			price: true,
			full: imageSelect,
			images: {
				select: {
					image: imageSelect
				},
				where: {
					imageable_type: 'work'
				}
			},
			titles: {
				select: {
					title: true,
					description: true,
					alt: true,
					language: true
				}
			},
			owners: {
				select: {
					user: {
						select: userSelect
					}
				},
				where: {
					ownable_type: 'work'
				}
			},
			votes: {
				select: {
					user: {
						select: userSelect
					}
				},
				where: {
					votable_type: 'work'
				}
			},
			tags: {
				select: {
					tag: {
						select: {
							titles: {
								select: {
									title: true,
									language: true
								}
							}
						}
					}
				},
				where: {
					taggable_type: 'work'
				}
			},
			details: {
				select: {
					year: true,
					width: true,
					height: true,
					length: true
				}
			}
		},
		where: {
			id
		}
	});
}
