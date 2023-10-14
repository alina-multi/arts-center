import type { Work } from '$lib/interfaces/Work';
import { taggableMap } from './tag';

import { ownersMap } from './owners';
import { imagablePicturesMap, pictureMap } from '$lib/server/mappers/pictures';
import type { Picture } from '$lib/interfaces/Picture';
import type { WorkRaw } from '$lib/interfaces/raw/WorkRaw';

export function workMap(data: WorkRaw): Work {
	return {
		...data,
		price: null,
		images: imagablePicturesMap(data.images),
		owners: ownersMap(data.owners),
		tags: taggableMap(data.tags),
		full: pictureMap(data.full),
		votes: ownersMap(data.votes),
		width: data?.details?.width ?? null,
		height: data?.details?.height ?? null,
		length: data?.details?.length ?? null,
		year: data?.details?.year ?? null,
		preview: pictureMap(data.preview)
	};
}

export function workPreviewMap(data: WorkRaw): Work & { preview: Picture | null } {
	return {
		...workMap(data),
		preview: pictureMap(data.preview),
		published_at: data.published_at
	};
}
