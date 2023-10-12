import type { User } from '$lib/interfaces/User';
import { pictureMap } from '$lib/server/mappers/pictures';
import type { user_basic_raw } from '../repositories/user';

export interface ownableWithRelations {
	user: user_basic_raw;
}

export function ownersMap(owners: ownableWithRelations[]): User[] {
	return owners
		?.filter(({ user }) => user)
		.map(({ user }) => {
			return ownerMap(user);
		});
}

export function ownerMap(user: user_basic_raw): User {
	return {
		id: user.id,
		username: user.username,
		name: user.name,
		photo: pictureMap(user.photo),
		country: user.country
	};
}
