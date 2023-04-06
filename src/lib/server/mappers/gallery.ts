import type { WorkPreview } from '$lib/interfaces/Work';
import { imageMap } from './image';
import { ownersMap } from './owners';
import type { Owner } from './owners';
import type { images, works, users, work_titles, ownables } from '@prisma/client';
import { languageFind } from '$lib/translations';

type Gallery = works & {
	owners: Owner[];
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
