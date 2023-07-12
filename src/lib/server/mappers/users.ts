import type { User, UserList } from '$lib/interfaces/User';
import type { user_bios, users } from '.prisma/client';
import type { RatingWithRelations } from './ratings';
import { ratingsMap } from './ratings';
import type { WorksWithRelations } from './gallery';
import { worksPreviewMap } from './gallery';
import { query } from '$lib/server/repositories/gallery';
import type { images } from '@prisma/client';
import { languageFind } from '$lib/translations';
import { pictureMap } from "$lib/server/mappers/pictures";

type userWithRelations = {
	id: bigint;
	name: string;
	username: string;
	created_at: Date | null;
	country: string | null;
	rating: number;
	photo: images | null;
	ratings?: RatingWithRelations[];
	bios?: user_bios[];
};

type prismaCountryAggregation = {
	country: string;
	_count: {
		country: number;
	};
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
				1,
				3
			);
			const works = worksPreviewMap(tmpWorks as WorksWithRelations[]);
			return {
				...userMap(user),
				works,
				photo: pictureMap(user.photo)
			};
		})
	);
}

export function userMap(user: userWithRelations): User {
	return {
		id: user.id,
		name: user.name,
		username: user.username,
		country: user.country,
		created_at: user.created_at,
		rating: user.rating,
		ratings: ratingsMap(user.ratings),
		photo: pictureMap(user.photo),
		bio: languageFind(user.bios)?.text
	};
}

export function userCountriesMap(
	countries: prismaCountryAggregation[],
	locale: string
): { title: string; count: number }[] {
	const regionNames = new Intl.DisplayNames([locale], { type: 'region' });
	return countries.map((country): { title: string; count: number } => {
		return {
			title: regionNames.of(country.country) ?? country.country,
			count: country._count.country
		};
	});
}
