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
	preview?: Picture | null;
	owners: UserPreview[];
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
	language: string;
}
