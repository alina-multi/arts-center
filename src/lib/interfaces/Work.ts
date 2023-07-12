import type { Picture } from './Picture';
import type { UserPreview } from './User';
import type { Tag } from './Tag';

export interface WorkPreview {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number | null;
	titles: WorkTitle[];
	image?: Picture;
	owners: UserPreview[];
}

export interface Work extends WorkPreview {
	year: number | null;
	width: number | null;
	height: number | null;
	length: number | null;
	tags?: Tag[];
	votes?: UserPreview[];
}

export interface WorkTitle {
	title: string;
	language: string;
}

export interface WorkBlock {
	id: bigint;
	language: string;
	type: string;
	data: object;
	images?: Picture[];
}
