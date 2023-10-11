import type { Work } from '$lib/interfaces/Work';
import type { imageables, images } from '@prisma/client';

import { taggableMap } from './tag';

import { ownersMap } from './owners';
import { imagablePicturesMap, pictureMap } from '$lib/server/mappers/pictures';
import type { Picture } from '$lib/interfaces/Picture';
import type {  work_raw  } from '../repositories/work';

interface worksWithRelations extends  work_raw  {
	blocks: [
		{
			images: imageables & {
				image: images;
			};
		}
	];
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

export function workPreviewMap(data: worksWithRelations): Work & { preview: Picture | null } {
	return {
		...workMap(data),
		preview: pictureMap(data.preview),
		published_at: data.published_at
	};
}
