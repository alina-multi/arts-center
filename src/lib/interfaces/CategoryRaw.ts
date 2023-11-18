import type { TagTitleRaw } from './TagRaw';

export interface CategoryRaw {
	id: bigint;
	count: number | null;
	titles: TagTitleRaw[];
	deleted_at: string | null;
}
