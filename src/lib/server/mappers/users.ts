import type { User, UserList } from '$lib/interfaces/User';
import type { user_bios } from '@prisma/client';
import type { RatingWithRelations } from './ratings';
import { ratingsMap } from './ratings';
import { worksPreviewMap } from './gallery';
import { query } from '$lib/server/repositories/gallery';
import { languageFind } from '$lib/translations';
import { pictureMap } from '$lib/server/mappers/pictures';
import type { imageWithRelation } from '$lib/server/mappers/pictures';

type userWithRelations = {
	id: bigint;
	name: string;
	username: string;
	created_at: Date | null;
	country: string | null;
	rating: number;
	photo: imageWithRelation | null;
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
			const works = worksPreviewMap(tmpWorks);
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
): { title: string; count: number; value: string }[] {
	const regionNames = new Intl.DisplayNames([locale], { type: 'region' });
	return countries.map((country): { title: string; count: number; value: string } => {
		return {
			title: regionNames.of(country.country.toUpperCase()) ?? '',
			value: country.country,
			count: country._count.country
		};
	});
}
