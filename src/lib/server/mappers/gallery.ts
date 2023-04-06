import type { WorkPreview } from '$lib/interfaces/Work';
import { imageMap } from './image';
import type { ownableWithRelations } from './owners';
import { ownersMap } from './owners';
import type { images, work_titles, works } from '@prisma/client';

type Gallery = works & {
	owners: ownableWithRelations[];
	image: images;
	titles: work_titles[];
};
export function worksPreviewMap(works: Gallery[]): WorkPreview[] {
	return works?.map((work) => {
		return {
			id: work.id,
			published_at: work.published_at,
			rating: work.rating,
			comments: work.comments,
			hosts: work.hosts,
			price: work.price,
			titles: work.titles,
			image: imageMap(work.image),
			owners: ownersMap(work.owners)
		};
	});
}
