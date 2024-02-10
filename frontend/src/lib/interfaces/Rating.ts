import type { Tag } from './Tag';

export interface Rating {
	rating: number;
	language: string;
	tag?: Tag;
}
