import type { Work } from '$lib/interfaces/Work';
import type {
	works,
	work_blocks,
	work_details,
	work_titles,
	users,
	taggables,
	votes
} from '@prisma/client';
import type { WorkBlock } from '$lib/interfaces/Work';
import { imagesMap } from './image';
import { ownersMap } from './owners';
import { taggableMap } from './tag';

interface worksWithRelations extends works {
	blocks: work_blocks[];
	titles: work_titles[];
	details: work_details;
	owners: users[];
	tags: taggables[];
	votes: votes[];
}
export function workMap(data: worksWithRelations): Work {
	return {
		...data,
		blocks: blocksMap(data.blocks),
		owners: ownersMap(data.owners),
		tags: taggableMap(data.tags),
		votes: ownersMap(data.votes)
	};
}

function blocksMap(blocks: work_blocks[]): WorkBlock[] {
	if (!blocks) return [];
	return blocks.map((row) => {
		return {
			id: row.id,
			language: row.language,
			type: row.type,
			data: JSON.parse(row.data),
			images: imagesMap(row.images)
		};
	});
}
