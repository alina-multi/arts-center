import type { Picture } from './Picture';
import type { UserPreview } from './User';
import type { Tag } from './Tag';
import type { work_titles_raw } from '$lib/server/repositories/work';
import type { image_raw } from '$lib/server/repositories/image';
import type { tag_titles_row } from '$lib/server/repositories/tag';

export interface WorkPreview {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number | null;
	titles: work_titles_raw[] | tag_titles_row [];
	preview: image_raw | Picture | null;
	owners: UserPreview[];
	status?: number 
}

export interface Work extends WorkPreview {
	year: number | null;
	width: number | null;
	height: number | null;
	length: number | null;
	tags?: Tag[];
	votes?: UserPreview[];
	full: Picture | null;
	images: Picture[];
}

export interface WorkTitle {
	title: string;
	description: string| null;
	alt: string| null;
	language: string;
}
