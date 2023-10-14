import type { UserBasic } from '$lib/interfaces/User';
import { pictureMap } from '$lib/server/mappers/pictures';
import type { UserBasicRaw } from '$lib/interfaces/raw/UserRaw';

export interface ownableWithRelations {
	user: UserBasicRaw;
}

export function ownersMap(owners: ownableWithRelations[]): UserBasic[] {
	return owners
		?.filter(({ user }) => user)
		.map(({ user }) => {
			return ownerMap(user);
		});
}

export function ownerMap(user: UserBasicRaw): UserBasic {
	return {
		id: user.id,
		username: user.username,
		name: user.name,
		photo: pictureMap(user.photo),
		country: user.country
	};
}
