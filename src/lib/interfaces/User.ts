import type { Image } from '$lib/interfaces/Image';
import type { WorkPreview } from './Work';

export interface UserPreview {
	id: bigint;
	username: string;
	avatar: Image | null;
	name: string;
	country: string | null;
	rating: number;
	works?: WorkPreview[];
}

export interface UserList extends UserPreview {
	created_at: Date | null;
}

interface UserRating {
	rating: number;
	ratable_type: string;
	ratable_id: bigint;
	language: string;
}

interface UserBio {
	language: string;
	text: string;
}

export interface User extends UserList {
	bio?: string;
}
