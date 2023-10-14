import type { WorkTitleFullRaw } from "$lib/interfaces/raw/WorkRaw";
import type { titles_raw } from '$lib/server/repositories/user';

export const work_titels_data_raw = [
	{
		title: 'Тестовий заголовок',
		description: null,
		alt: null,
		language: 'uk'
	},
	{
		title: 'Test header',
		description: 'work description',
		alt: 'work alt',
		language: 'en'
	}
] satisfies WorkTitleFullRaw[];

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
