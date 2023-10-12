import type { RatingWithRelations } from '$lib/server/mappers/ratings';
import type { Rating } from '$lib/interfaces/Rating';

export const user_rating = {
	id: 100n,
	ratable_type: 'work',
	ratable_id: 200n,
	user_id: 300n,
	rating: 1,
	created_at: null,
	updated_at: null,
	language: 'en',
	tag: undefined
} satisfies RatingWithRelations;

export const RatingData = {
	rating: 1,
	language: 'en',
	tag: undefined
} satisfies Rating;

// tag?: Tag;

export const tag = {
	id: 100n,
	count: 2,
	type_id: 1
};

export const TagData = {
	id: 100n,
	count: undefined,
	title: 'photo'
};
