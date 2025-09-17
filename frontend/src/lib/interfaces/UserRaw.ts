import type { ImageRaw } from './ImageRaw';

export interface UserBasicRaw {
	id: bigint;
	username: string;
	name: string;
	photo: ImageRaw | null;
	country: string | null;
	rating: number;
	verified_at: string | null;
}

export interface UserFullRaw extends UserBasicRaw {
	approved_at: string | null;
	created_at: Date;
	ratings: UserRatingsRow[] | [];
	bios: [
		{
			text: string;
			language: string;
		}
	];
}

export interface UserRatingsRow {
	rating: number;
	language: string;
	tag: {
		id: bigint;
		titles: titles_raw[];
	} | null;
}

export interface titles_raw {
	title: string;
	language: string;
}
