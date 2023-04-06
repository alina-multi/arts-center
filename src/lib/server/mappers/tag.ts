import type { taggables, tags } from '@prisma/client';
import type { Tag } from '$lib/interfaces/Tag';
import type { TagTitle } from '$lib/interfaces/Tag';
import { languageFind } from '$lib/translations';

interface tagsWithRelations extends tags {
	titles: TagTitle[];
}

interface taggablesWithRelations extends taggables {
	tag: tagsWithRelations;
}
export function tagsMap(tags: tagsWithRelations[]): Tag[] {
	return tags?.map((tag) => {
		return {
			id: tag.id,
			title: languageFind(tag.titles)?.title,
			count: tag.count
		}
	});
}

export function taggableMap(taggables: taggablesWithRelations[]): Tag[] {
	return taggables?.map((taggable) => {
		return {
			id: taggable.tag.id,
			title: languageFind(taggable.tag.titles)?.title,
			count: taggable.tag.count
		};
	});
}
