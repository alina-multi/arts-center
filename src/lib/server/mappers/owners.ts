import type { images, users } from '@prisma/client';
import type { User } from '$lib/interfaces/User';
import { imageMap } from './image';

export interface ownableWithRelations {
	user: usersWithRelations;
}

export interface usersWithRelations extends users {
	avatar: images;
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
		avatar: imageMap(user.avatar),
		country: user.country
	};
}
