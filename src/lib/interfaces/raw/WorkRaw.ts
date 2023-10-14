import type { ImageRaw } from './ImageRaw';
import type { UserBasicRaw } from './UserRaw';
import type { TagTitleRaw } from './TagRaw';

export interface WorkPreviewRaw {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number;
	preview: ImageRaw | null;
	status?: number;
	images: { image: ImageRaw }[] | [];
	titles: WorkTitleShort[];
	owners: { user: UserBasicRaw }[];
}

export interface WorkRaw extends WorkPreviewRaw {
	full: ImageRaw | null;
	votes: { user: UserBasicRaw }[];
	tags:
		| {
				tag: {
					id: bigint;
					titles: TagTitleRaw[];
				};
		  }[]
		| [];
	details: WorkDetailsRaw | null;
}

export interface WorkDetailsRaw {
	year: number | null;
	width: number | null;
	height: number | null;
	length: number | null;
}

export interface WorkTitleShort {
	title: string | null;
	language: string;
}

export interface WorkTitleFullRaw extends WorkTitleShort {
	description: string | null;
	alt: string | null;
}
