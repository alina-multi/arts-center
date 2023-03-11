import type { Image } from './Image';
import type { UserPreview } from './User';
export interface WorkPreview {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number;
	titles: WorkTitle[];
	image?: Image;
	owners: UserPreview[];
}

export interface Work extends WorkPreview {
	blocks: WorkBlock[];
	year?: number;
	width?: number;
	height?: number;
	length?: number;
	image?: Image;
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
}
