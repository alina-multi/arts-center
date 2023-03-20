import type { taggables, tags } from '@prisma/client';
import type { Tag } from '$lib/interfaces/Tag';
import type { TagTitle } from '../../interfaces/Tag';

interface tagsWithRelations extends tags {
	titles: TagTitle[];
}

interface taggablesWithRelations extends taggables {
	tag: tagsWithRelations;
}
export function tagsMap(tags: tagsWithRelations[]): Tag[] {
	return tags?.map((tag) => {
		return {
			...tag
		};
	});
}

export function taggableMap(taggables: taggablesWithRelations[]): Tag[] {
	return taggables?.map((taggable) => {
		return {
			...taggable.tag
		};
	});
}
