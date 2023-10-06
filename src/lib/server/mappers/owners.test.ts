import { ownerMap, ownersMap } from '$lib/server/mappers/owners';
import { expect, test } from 'vitest';
import User from '$test/data/UserData';

const owners = [{ user: User }, { user: User }];

test('ownerMap', () => {
	const result = ownerMap(User);

	expect(result).toMatchInlineSnapshot(`
		{
		  "country": null,
		  "id": 12n,
		  "name": "Test-test",
		  "photo": null,
		  "username": "serena10"
		}
	`);
});

test('ownersMap', () => {
	const result = ownersMap(owners);
	expect(result).toMatchInlineSnapshot(`
		[
		  {
		    "country": null,
		    "id": 12n,
		    "name": "Test-test",
		    "photo": null,
		    "username": "serena10",
		  },
		  {
		    "country": null,
		    "id": 12n,
		    "name": "Test-test",
		    "photo": null,
		    "username": "serena10",
		  },
		]
	`);
});
