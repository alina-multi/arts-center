import type { Picture } from '$lib/interfaces/Picture';
import type { WorkPreview } from './Work';
import type { Rating } from './Rating';

export interface UserBasic {
	id: bigint;
	username: string;
	name: string;
	photo: Picture | null;
	country: string | null;
}

export interface UserPreview extends UserBasic {
	rating?: number;
	works?: WorkPreview[];
	ratings?: Rating[];
}

export interface UserList extends UserPreview {
	created_at: Date;
}

export interface User extends UserList {
	bio?: string;
}
