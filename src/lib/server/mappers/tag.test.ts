import { expect, test, beforeAll } from 'vitest';
import { loadTranslations } from '$lib/translations';
import { tagsMap, taggableMap } from './tag';
import { category_data_raw } from '$test/data/TagData';

beforeAll(async () => {
	await loadTranslations('uk', '/uk/');
});

test('tagsMap', () => {
	const categories = [category_data_raw, { ...category_data_raw, id: 12n, count: 3 }];

	const result = tagsMap(categories, 'uk');
	expect(result).toMatchInlineSnapshot(`
      [
        {
          "id": 11n,
          "title": "Тестовий заголовок",
        },
        {
          "count": 3,
          "id": 12n,
          "title": "Тестовий заголовок",
        },
      ]
    `);
});

test('taggableMap', () => {
	const taggables = [
		{ tag: category_data_raw },
		{ tag: { ...category_data_raw, id: 12n, count: 3 } }
	];

	const result = taggableMap(taggables, 'uk');

	expect(result).toMatchInlineSnapshot(`
      [
        {
          "id": 11n,
          "title": "Тестовий заголовок",
        },
        {
          "count": 3,
          "id": 12n,
          "title": "Тестовий заголовок",
        },
      ]
    `);
});
