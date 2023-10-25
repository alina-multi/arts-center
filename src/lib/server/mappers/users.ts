import type { User, UserList } from '$lib/interfaces/User';
import { ratingsMap } from './ratings';
import { worksPreviewMap } from './gallery';
import { query } from '$lib/server/repositories/gallery';
import { languageFind } from '$lib/translations';
import { pictureMap } from '$lib/server/mappers/pictures';
import type { UserFullRaw } from '$lib/interfaces/UserRaw';

type prismaCountryAggregation = {
	country: string;
	_count: {
		country: number;
	};
};
export async function usersMap(users: UserFullRaw[]): Promise<UserList[]> {
	return await Promise.all(
		users.map(async (user: UserFullRaw) => {
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

export function userMap(user: UserFullRaw): User {
	return {
		id: user.id,
		name: user.name,
		username: user.username,
		country: user.country,
		created_at: user.created_at,
		verified_at: user.verified_at,
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
