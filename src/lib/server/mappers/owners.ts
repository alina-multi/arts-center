import type { images, users } from '@prisma/client';
import type { User } from '$lib/interfaces/User';
import { pictureMap } from "$lib/server/mappers/pictures";

export interface ownableWithRelations {
	user: usersWithRelations;
}

export interface usersWithRelations extends users {
	photo: images;
}
export function ownersMap(owners: ownableWithRelations[]): User[] {
	return owners
		?.filter(({ user }) => user)
		.map(({ user }) => {
			return ownerMap(user);
		});
}

export function ownerMap(user: usersWithRelations): User {
	return {
		id: user.id,
		username: user.username,
		name: user.name,
		photo: pictureMap(user.photo),
		country: user.country
	};
}
