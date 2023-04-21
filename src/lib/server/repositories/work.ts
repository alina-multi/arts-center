import { PrismaClient } from '@prisma/client';
import { userSelect } from './user';

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
			titles: {
				select: {
					title: true,
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
			},
			blocks: {
				select: {
					id: true,
					language: true,
					type: true,
					order: true,
					data: true,
					images: {
						select: {
							image: {
								select: {
									id: true,
									name: true,
									folder: true,
									w1200: true,
									w2400: true
								}
							}
						},
						where: {
							imageable_type: {
								// todo: once this is fixed, remove the workaround
								in: ['work_block', 'App\\WorkBlock']
							}
						}
					}
				},
				orderBy: {
					order: 'asc'
				}
			}
		},
		where: {
			id
		}
	});
}
