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
	image: Image | null;
	owners: UserPreview[];
}

export interface Work extends WorkPreview {
	details?: {
		width: number;
		height: number;
		length: number;
	};
}

export interface WorkTitle {
	title: string;
	language: string;
}
