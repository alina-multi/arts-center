import type { CategoryRaw } from '$lib/interfaces/CategoryRaw';
import { titles_data_raw } from './TitlesData';

export const category_data_raw = {
	id: 11n,
	count: null,
	titles: titles_data_raw,
	deleted_at: null
} satisfies CategoryRaw;
