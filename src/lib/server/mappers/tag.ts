import type { Tag, Category } from '$lib/interfaces/Tag';
import { languageFind } from '$lib/translations';
import type { CategoryRaw } from '$lib/interfaces/CategoryRaw';
import type { TagRaw } from '$lib/interfaces/TagRaw';

export function tagsMap(tags: CategoryRaw[]): Tag[] {
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

export function taggableMap(taggables: { tag: CategoryRaw }[] | TagRaw[]): Tag[] | Category[] {
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
