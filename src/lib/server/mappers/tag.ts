import type { Category, Tag } from '$lib/interfaces/Tag';
import { languageFind } from '$lib/translations';
import type { CategoryRaw } from '$lib/interfaces/CategoryRaw';
import type { TagRaw } from '$lib/interfaces/TagRaw';

export function tagsMap(tags: CategoryRaw[], lang: 'en' | 'uk'): Tag[] {
	let count = {};
	return tags
		?.filter((tag) => tag.deleted_at === null)
		?.map((tag) => {
			if (tag.count) {
				count = { count: tag.count };
			}

			return {
				id: tag.id,
				title: languageFind(tag.titles, lang)?.title || '',
				...count
			};
		});
}

export function taggableMap(
	taggables: { tag: CategoryRaw }[] | TagRaw[],
	lang: 'en' | 'uk'
): Tag[] | Category[] {
	let count = {};
	return taggables?.map((taggable) => {
		if (taggable.tag.count) {
			count = { count: taggable.tag.count };
		}
		return {
			id: taggable.tag?.id,
			title: languageFind(taggable.tag.titles, lang)?.title || '',
			...count
		};
	});
}
