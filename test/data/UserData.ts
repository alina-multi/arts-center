import type { UserBasic } from '$lib/interfaces/User';
import type { UserBasicRaw } from '$lib/interfaces/raw/UserRaw';

export const user_basic_data_raw = {
	id: 12n,
	username: 'username',
	photo: null,
	name: 'Name',
	country: null,
	rating: 0
} satisfies UserBasicRaw;

export const UserBasicData = {
	id: 12n,
	username: 'username',
	photo: null,
	name: 'Name',
	country: null
} as UserBasic;
