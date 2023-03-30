import type { Image } from '$lib/interfaces/Image';
import type { WorkPreview } from './Work';

export interface UserPreview {
	id: bigint;
	username: string;
	avatar: Image | null;
	name: string;
	country: string | null;
	works?: WorkPreview[];
}

export interface UserList extends UserPreview {
	created_at: Date;
}

interface UserRating {
	rating: number;
	ratable_type: string;
	ratable_id: bigint;
	language: string;
}

export type User = UserPreview;
