import { languageFind, languageFilter } from '$lib/translations';
import type { Rating } from '$lib/interfaces/Rating';
import type { tag_titles, tags, user_ratings } from '@prisma/client';
import type { Tag } from '$lib/interfaces/Tag';

export interface RatingWithRelations extends user_ratings {
	tag?: tags & {
		titles?: tag_titles[];
	};
}

export function ratingsMap(ratings?: RatingWithRelations[]): Rating[] {
	ratings = languageFilter(ratings);
	return (
		ratings?.map((rating) => {
			let optional: { tag?: Tag } = {};
			if (rating.tag) {
				const title = languageFind(rating?.tag?.titles)?.title;
				// Let's ignore the tag if it has no title in the current language
				if (title) {
					optional.tag = {
						id: rating.tag.id,
						title: title
					};
				}
			}
			return {
				rating: rating.rating,
				language: rating.language,
				...optional
			};
		}) || []
	);
}
