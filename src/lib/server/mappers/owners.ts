import type { users, images } from '@prisma/client';
import type { User } from '$lib/interfaces/User';
import { imageMap } from './image';

interface Owner {
	user: users & {
		avatar: images | null;
	};
}
export function ownersMap(owners: Owner[]): User[] {
	return owners.map(({ user }) => {
		return ownerMap(user);
	});
}

export function ownerMap(user: users): User {
	return {
		id: user.id,
		username: user.username,
		name: user.name,
		avatar: imageMap(user.avatar),
		country: user.country
	};
}
