import type { Picture } from '$lib/interfaces/Picture';
import type { UserBasic } from '$lib/interfaces/User';
import type { PostRow } from '$lib/interfaces/PostRaw';

export interface Post {
	id: bigint;
	rating: number;
	comments: number;
	published_at: Date;
	updated_at: Date;
	title: string;
	body: PostRow[];
	language: string;
	images: Map<string, Picture | null>;
	owner: UserBasic;
	image: Picture | null;
}
