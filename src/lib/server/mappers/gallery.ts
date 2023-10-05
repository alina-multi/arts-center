import type { WorkPreview } from '$lib/interfaces/Work';
import type { ownableWithRelations } from './owners';
import { ownersMap } from './owners';
import type { images, work_titles, works } from '@prisma/client';
import { pictureMap } from '$lib/server/mappers/pictures';

export type WorksWithRelations = works & {
	owners: ownableWithRelations[];
	preview: images;
	titles: work_titles[];
};
export function worksPreviewMap(works: WorksWithRelations[]): WorkPreview[] {
	return works?.map((work) => {
		return {
			id: work.id,
			published_at: work.published_at,
			rating: work.rating,
			comments: work.comments,
			hosts: work.hosts,
			price: null,
			titles: work.titles,
			owners: ownersMap(work.owners),
			preview: pictureMap(work.preview)
		};
	});
}
