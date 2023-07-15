import type { Work, WorkBlock } from '$lib/interfaces/Work';
import type {
	imageables,
	votes,
	work_blocks,
	work_details,
	work_titles,
	works,
	images
} from '@prisma/client';
import type { taggablesWithRelations } from './tag';
import { taggableMap } from './tag';
import type { ownableWithRelations, usersWithRelations } from './owners';
import { ownersMap } from './owners';
import { imagablePicturesMap, picturesMap, pictureMap } from '$lib/server/mappers/pictures';

interface workBlocksWithRelations extends work_blocks {
	images: imageables & {
		image: images;
	};
}
interface worksWithRelations extends works {
	blocks: workBlocksWithRelations[];
	titles: work_titles[];
	details: work_details;
	owners: ownableWithRelations[];
	tags: taggablesWithRelations[];
	images: imageables;
	votes: (votes & {
		user: usersWithRelations;
	})[];
}
export function workMap(data: worksWithRelations): Work {
	return {
		...data,
		images: imagablePicturesMap(data.images),
		owners: ownersMap(data.owners),
		tags: taggableMap(data.tags),
		full: pictureMap(data.full),
		votes: ownersMap(data.votes),
		width: data?.details?.width,
		height: data?.details?.height,
		length: data?.details?.length,
		year: data?.details?.year,
		full: pictureMap(data.full)
	};
}

function blocksMap(blocks: workBlocksWithRelations[]): WorkBlock[] | undefined {
	return blocks?.map((row) => {
		return {
			id: row.id,
			language: row.language,
			type: row.type,
			data: JSON.parse(row.data),
			images: picturesMap(row.images)
		};
	});
}
