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

export interface UserMe extends UserBasic {
	blacklists: bigint[];
	follows: {
		user: bigint[];
		work: bigint[];
	};
	favorites: {
		works: bigint[];
		folders: {
			id: bigint;
			title: string;
		}[];
	};
	approved_at: string | null;
	email_verified_at: string | null;
	admin?: boolean;
}
