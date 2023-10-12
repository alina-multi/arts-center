import { expect, test, beforeAll } from 'vitest';
import {  user_rating_data_row } from '$test/data/RatingData';
import { ratingsMap } from './ratings';
import { loadTranslations } from '$lib/translations';

const user_ratings = [
	user_rating_data_row,
	{ ...user_rating_data_row, language: 'uk' },
	{ ...user_rating_data_row, language: 'uk', tag: null }
];

beforeAll(async () => {
	await loadTranslations('uk', '/uk/');
});

test('ratingsMap', () => {
	const result = ratingsMap(user_ratings);
	expect(result).toMatchInlineSnapshot(`
		[
		  {
		    "language": "uk",
		    "rating": 1,
		    "tag": {
		      "id": 11n,
		      "title": "Тестовий заголовок",
		    },
		  },
		  {
		    "language": "uk",
		    "rating": 1,
		  },
		]
	`);
});
