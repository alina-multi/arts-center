import type { UserBasic } from '$lib/interfaces/User';
import type { UserBasicRaw } from '$lib/interfaces/UserRaw';

export const user_basic_data_raw = {
	id: 12n,
	username: 'username',
	photo: null,
	name: 'Name',
	country: null,
	rating: 0,
	verified_at: null
	
} satisfies UserBasicRaw;

export const UserBasicData = {
	id: 12n,
	username: 'username',
	photo: null,
	name: 'Name',
	country: null,
	verified_at: null
} as UserBasic;


export const UserMeData = {
	...UserBasicData,
	blacklists: [],
	follows: {
		user: [],
		work: [],
	},
	favorites: {
		works: [],
		folders: []
	},
	approved_at: null,
	email_verified_at: null,
	admin: false
}