import { prisma } from '$lib/server/database/prisma';
import { userSelect } from './user';
import { imageSelect } from '$lib/server/repositories/image';
import type { image_raw } from '$lib/server/repositories/image';
import type { user_basic_raw } from './user';
import type { tag_titles_row } from './tag';

export interface work_raw {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number;
	full: image_raw;
	preview: image_raw | null;
	images: [{ image: image_raw }] | [];
	titles: work_titles[];
	owners: [{ user: user_basic_raw }];
	votes: [{ user: user_basic_raw }];
	tags: [
		{
			tag: {
				id: bigint;
				titles: tag_titles_row[];
			};
		}
	];
	details: work_details;
}

interface work_details {
	year: number | null;
	width: number | null;
	height: number | null;
	length: number | null;
}

export interface work_titles {
	title: string | null;
	description: string | null;
	alt: string | null;
	language: string;
}

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
