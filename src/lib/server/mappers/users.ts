import type { Userlist } from '$lib/interfaces/User';
import type { users } from '.prisma/client';
import { imageMap } from './image';
import { query } from '$lib/server/repositories/gallery';
import { worksPreviewMap } from './gallery';

export async function usersMap(users: users[]): Promise<Userlist[]> {
	return await Promise.all(
		users.map(async (user) => {
			let works = await query(
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
			works = worksPreviewMap(works);

			return {
				...user,
				works,
				avatar: imageMap(user.avatar)
			};
		})
	);
}
