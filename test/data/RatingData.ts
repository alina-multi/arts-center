import type { user_ratings_row } from '$lib/server/repositories/user';
import type { titles_raw } from '$lib/server/repositories/user';

const titles_data_raw = [
	{
		language: 'uk',
		title: 'Тестовий заголовок'
	},
	{
		language: 'en',
		title: 'Test header'
	}
] satisfies titles_raw[];

export const user_rating_data_row = {
	rating: 1,
	language: 'en',
	tag: {
		id: 11n,
		titles: titles_data_raw
	}
} satisfies user_ratings_row;


