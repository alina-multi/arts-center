import type { Tag } from '$lib/interfaces/Tag';
import { languageFind } from '$lib/translations';
import type { category_raw } from '../repositories/tag';

export function tagsMap(tags: category_raw[]): Tag[] {
	let count = {};
	return tags?.map((tag) => {
		if (tag.count) {
			count = { count: tag.count };
		}

		return {
			id: tag.id,
			title: languageFind(tag.titles)?.title || '',
			...count
		};
	});
}

export function taggableMap(taggables: { tag: category_raw }[]): Tag[] {
	let count = {};
	return taggables?.map((taggable) => {
		if (taggable.tag.count) {
			count = { count: taggable.tag.count };
		}
		return {
			id: taggable.tag?.id,
			title: languageFind(taggable.tag.titles)?.title || '',
			...count
		};
	});
}
