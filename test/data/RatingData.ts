import type { user_ratings_row } from '$lib/server/repositories/user';
import { titles_data_raw } from './TitlesData';



export const user_rating_data_row = {
	rating: 1,
	language: 'en',
	tag: {
		id: 11n,
		titles: titles_data_raw
	}
} satisfies user_ratings_row;


