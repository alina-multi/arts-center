import type { WorkPreview } from '$lib/interfaces/Work';
import { imageMap } from './image';
import type { Gallery } from '$server/repositories/gallery';
import { ownersMap } from './owners';

export function worksPreviewMap(works: Gallery): WorkPreview[] {
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
