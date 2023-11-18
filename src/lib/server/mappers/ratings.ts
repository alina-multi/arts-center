import { languageFind, languageFilter } from '$lib/translations';
import type { Rating } from '$lib/interfaces/Rating';
import type { Tag } from '$lib/interfaces/Tag';
import type { UserRatingsRow } from '$lib/interfaces/UserRaw';

export function ratingsMap(ratings: UserRatingsRow[], lang: string): Rating[] {
	ratings = languageFilter(ratings, lang);
	return (
		ratings?.map((rating) => {
			const optional: { tag?: Tag } = {};
			if (rating.tag) {
				const title = languageFind(rating?.tag?.titles, lang)?.title;
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
