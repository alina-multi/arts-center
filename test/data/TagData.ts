import type { category_raw } from '$lib/server/repositories/tag';
import type { titles_raw } from '$lib/server/repositories/user';

export const titles_data_raw = [
	{
		language: 'uk',
		title: 'Тестовий заголовок'
	},
	{
		language: 'en',
		title: 'Test header'
	}
] satisfies titles_raw[];

export const category_data_raw = {
	id: 11n,
	count: null,
	titles: titles_data_raw
} satisfies category_raw;
