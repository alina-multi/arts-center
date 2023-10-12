import type { Tag } from '$lib/interfaces/Tag';
import { languageFind } from '$lib/translations';
import type { category_raw } from '../repositories/tag';

export function tagsMap(tags: category_raw[]): Tag[] {
	return tags?.map((tag) => {
		return {
			id: tag.id,
			title: languageFind(tag.titles)?.title || '',
			...() => (tag.count ? { count: tag.count } : {})
		};
	});
}

export function taggableMap(taggables: [{ tag: category_raw }]): Tag[] {
	return taggables?.map((taggable) => {
		return {
			id: taggable.tag?.id,
			title: languageFind(taggable.tag.titles)?.title || '',
			...() => (taggable?.tag?.count ? { count: taggable.tag.count } : {})
		};
	});
}
