import type { Image } from '$lib/interfaces/Image';
import type { WorkPreview } from './Work';
import type { Rating } from './Rating';

export interface UserPreview {
	id: bigint;
	username: string;
	avatar: Image | null;
	name: string;
	country: string | null;
	rating: number;
	works?: WorkPreview[];
	ratings?: Rating[];
}

export interface UserList extends UserPreview {
	created_at: Date | null;
}

interface UserBio {
	language: string;
	text: string;
}

export interface User extends UserList {
	bio?: string;
}
