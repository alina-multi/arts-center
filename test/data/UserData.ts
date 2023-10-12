import type { User } from '$lib/interfaces/User';
import type { user_basic_raw } from '$lib/server/repositories/user';

export const user_basic_data_raw = {
	id: 12n,
	username: 'username',
	photo: null,
	name: 'Name',
	country: null,
	rating: 0,
} satisfies user_basic_raw;

export const UserBasicData = {
	id: 12n,
	username: 'username',
	photo: null,
	name: 'Name',
	country: null
} as User;
