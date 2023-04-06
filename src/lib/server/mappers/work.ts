import type { Work } from '$lib/interfaces/Work';
import type { works, work_blocks, work_details, work_titles, votes } from '@prisma/client';
import type { WorkBlock } from '$lib/interfaces/Work';
import type { imageablesWithRelations } from './image';
import type { taggablesWithRelations } from './tag';
import type { ownableWithRelations, usersWithRelations } from './owners';
import { imagesMap } from './image';
import { ownersMap } from './owners';
import { taggableMap } from './tag';

interface workBlocksWithRelations extends work_blocks {
	images: imageablesWithRelations[];
}
interface worksWithRelations extends works {
	blocks: workBlocksWithRelations[];
	titles: work_titles[];
	details: work_details;
	owners: ownableWithRelations[];
	tags: taggablesWithRelations[];
	votes: (votes & {
		user: usersWithRelations;
	})[];
}
export function workMap(data: worksWithRelations): Work {
	return {
		...data,
		blocks: blocksMap(data.blocks),
		owners: ownersMap(data.owners),
		tags: taggableMap(data.tags),
		votes: ownersMap(data.votes),
		width: data.details.width,
		height: data.details.height,
		length: data.details.length,
		year: data.details.year
	};
}

function blocksMap(blocks: workBlocksWithRelations[]): WorkBlock[] | undefined {
	return blocks?.map((row) => {
		return {
			id: row.id,
			language: row.language,
			type: row.type,
			data: JSON.parse(row.data),
			images: imagesMap(row.images)
		};
	});
}
