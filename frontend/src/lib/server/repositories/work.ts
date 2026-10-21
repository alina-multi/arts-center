import { prisma } from '$lib/server/database/prisma';
import { userSelect } from './user';
import { imageSelect } from '$lib/server/repositories/image';
import { useMockData } from '$lib/server/mock/mode';
import { mockWorkGet } from '$lib/server/mock/read';

export function get(id: bigint) {
	if (useMockData()) {
		return Promise.resolve(mockWorkGet(id));
	}
	return prisma.works.findUnique({
		select: {
			id: true,
			published_at: true,
			rating: true,
			comments: true,
			hosts: true,
			price: true,
			full: imageSelect,
			preview: imageSelect,
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
							id: true,
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
