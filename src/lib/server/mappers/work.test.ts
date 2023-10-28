import { workMap, workPreviewMap } from './work';
import { expect, test } from 'vitest';
import { work_data_raw } from '$test/data/WorkData';

const data = { ...work_data_raw, full: null, owners: [], details: null };

test('workMap', () => {
	const result = workMap(data);
	expect(result).toMatchInlineSnapshot(`
		{
		  "comments": 0,
		  "details": null,
		  "full": null,
		  "height": null,
		  "hosts": 0,
		  "id": 1n,
		  "images": [],
		  "length": null,
		  "owners": [],
		  "preview": null,
		  "price": null,
		  "published_at": null,
		  "rating": 0,
		  "tags": [],
		  "titles": [
		    {
		      "alt": null,
		      "description": null,
		      "language": "uk",
		      "title": "Тестовий заголовок",
		    },
		    {
		      "alt": "work alt",
		      "description": "work description",
		      "language": "en",
		      "title": "Test header",
		    },
		  ],
		  "votes": [
		    {
		      "country": null,
		      "id": 12n,
		      "name": "Name",
		      "photo": null,
		      "username": "username",
		      "verified_at": null,
		    },
		  ],
		  "width": null,
		  "year": null,
		}
	`);
});

test('workPreviewMap', () => {
	const result = workPreviewMap(data);
	expect(result).toMatchInlineSnapshot(`
		{
		  "comments": 0,
		  "details": null,
		  "full": null,
		  "height": null,
		  "hosts": 0,
		  "id": 1n,
		  "images": [],
		  "length": null,
		  "owners": [],
		  "preview": null,
		  "price": null,
		  "published_at": null,
		  "rating": 0,
		  "tags": [],
		  "titles": [
		    {
		      "alt": null,
		      "description": null,
		      "language": "uk",
		      "title": "Тестовий заголовок",
		    },
		    {
		      "alt": "work alt",
		      "description": "work description",
		      "language": "en",
		      "title": "Test header",
		    },
		  ],
		  "votes": [
		    {
		      "country": null,
		      "id": 12n,
		      "name": "Name",
		      "photo": null,
		      "username": "username",
		      "verified_at": null,
		    },
		  ],
		  "width": null,
		  "year": null,
		}
	`);
});
