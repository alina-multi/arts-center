import type { WorkPreview } from '$lib/interfaces/Work';
import { ownersMap } from './owners';
import { pictureMap } from '$lib/server/mappers/pictures';
import type { works_raw } from '../repositories/gallery';

export function worksPreviewMap(works: works_raw[]): WorkPreview[] {

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
			preview: pictureMap(work.preview),
			status: work.status
		};
	});
}
