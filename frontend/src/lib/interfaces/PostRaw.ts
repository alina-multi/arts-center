import type { ImageRaw } from '$lib/interfaces/ImageRaw';
import type { UserBasicRaw } from '$lib/interfaces/UserRaw';

interface TextRow {
	type: 'text';
	text: string;
}

interface ImageRow {
	type: 'image';
	image_id: number;
}

export type PostRow = TextRow | ImageRow;

export interface PostRaw {
	id: bigint;
	rating: number;
	comments: number;
	published_at: Date;
	updated_at: Date;
	title: string;
	body: PostRow[];
	language: string;
	image?: ImageRaw;
	images?: { image: ImageRaw }[];
	owner?: UserBasicRaw;
}
