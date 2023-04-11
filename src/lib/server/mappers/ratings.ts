import { languageFind, languageFilter } from '$lib/translations';

export function ratingsMap(ratings) {
	ratings = languageFilter(ratings);
	return ratings?.map((rating) => {
		return {
			rating: rating.rating,
			language: rating.language,
			tag: rating.tag
				? {
						id: rating.tag.id,
						title: languageFind(rating.tag.titles)?.title || ''
				  }
				: undefined
		};
	});
}
