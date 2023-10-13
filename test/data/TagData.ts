import type { category_raw } from '$lib/server/repositories/tag';
import { titles_data_raw } from './TitlesData';

export const category_data_raw = {
	id: 11n,
	count: null,
	titles: titles_data_raw
} satisfies category_raw;
