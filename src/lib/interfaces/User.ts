import type { Image } from '$lib/interfaces/Image';

export interface UserPreview {
	id: bigint;
	username: string;
	avatar: Image | null;
	name: string;
}

export interface UserPage extends UserPreview {
	country: string;
	ratings: UserRating[];
}

interface UserRating {
	rating: number;
	ratable_type: string;
	ratable_id: bigint;
	language: string;
}

export type User = UserPreview;
