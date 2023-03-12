import type { tags } from '@prisma/client';
import type { Tag } from '$lib/interfaces/Tag';
import type { TagTitle } from '../../interfaces/Tag';

interface tagsWithRelations extends tags {
	titles: TagTitle[];
}
export function tagsMap(tags: tagsWithRelations[]): Tag[] {
	return tags.map((tag) => {
		return {
			...tag
		};
	});
}
