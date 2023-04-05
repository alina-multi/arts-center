import type { users, images } from '@prisma/client';
import type { User } from '$lib/interfaces/User';
import { imageMap } from './image';

export interface Owner {
	user: UserWithRelations;
}

interface UserWithRelations extends users {
	avatar: images | null;
}
export function ownersMap(owners: Owner[]): User[] {
	return owners
		?.filter(({ user }) => user)
		.map(({ user }) => {
			return ownerMap(user);
		});
}

export function ownerMap(user: UserWithRelations): User {
	return {
		id: user.id,
		username: user.username,
		name: user.name,
		avatar: imageMap(user.avatar),
		country: user.country
	};
}
