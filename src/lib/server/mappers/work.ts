import type { Work } from '$lib/interfaces/Work';
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
import { imagablePicturesMap, pictureMap } from '$lib/server/mappers/pictures';
import type { Picture } from '$lib/interfaces/Picture';

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
		price: null,
		images: imagablePicturesMap(data.images),
		owners: ownersMap(data.owners),
		tags: taggableMap(data.tags),
		full: pictureMap(data.full),
		votes: ownersMap(data.votes),
		width: data?.details?.width,
		height: data?.details?.height,
		length: data?.details?.length,
		year: data?.details?.year
	};
}

export function workPreviewMap(data: worksWithRelations): Work & { preview: Picture } {
	return {
		...workMap(data),
		preview: pictureMap(data.preview),
		published_at: data.published_at
	};
}
