import type { Picture } from './Picture';
import type { UserBasic } from './User';
import type { Tag } from './Tag';
import type { WorkTitleFullRaw, WorkTitleShort } from './raw/WorkRaw';



export interface WorkPreview {
	id: bigint;
	published_at: Date | null;
	rating: number;
	comments: number;
	hosts: number;
	price: number | null;
	titles: WorkTitleFullRaw[] | WorkTitleShort[];
	owners: UserBasic[];
	preview: Picture | null;
	status?: number;
}

export interface Work extends WorkPreview {
	year: number | null;
	width: number | null;
	height: number | null;
	length: number | null;
	tags?: Tag[];
	votes?: UserBasic[];
	full: Picture | null;
	images: Picture[];
}

export interface WorkTitle {
	title: string;
	description: string | null;
	alt: string | null;
	language: string;
}
