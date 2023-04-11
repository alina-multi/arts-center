import type { User, UserList } from '$lib/interfaces/User';
import type { users } from '.prisma/client';
import { imageMap } from './image';
import { query } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from './gallery';
import type { images } from '@prisma/client';
import { ratingsMap } from './ratings';

type userWithRelations = users & {
	avatar: images | null;
};
export async function usersMap(users: userWithRelations[]): Promise<UserList[]> {
	return await Promise.all(
		users.map(async (user: userWithRelations) => {
			const tmpWorks = await query(
				{
					owners: {
						some: {
							user_id: user.id
						}
					}
				},
				{
					rating: 'desc'
				},
				0,
				3
			);
			const works = worksPreviewMap(tmpWorks);

			return {
				...user,
				works,
				avatar: imageMap(user.avatar)
			};
		})
	);
}

export async function userMap(user: userWithRelations): Promise<User> {
	return {
		...user,
		ratings: ratingsMap(user.ratings),
		avatar: imageMap(user.avatar)
	};
}
