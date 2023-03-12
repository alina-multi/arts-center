import type { Image } from '$lib/interfaces/Image';

export interface UserPreview {
	id: bigint;
	username: string;
	avatar: Image | null;
	name: string;
	country: string | null;
}

export interface UserPage extends UserPreview {
	ratings: UserRating[];
}

interface UserRating {
	rating: number;
	ratable_type: string;
	ratable_id: bigint;
	language: string;
}

export type User = UserPreview;
