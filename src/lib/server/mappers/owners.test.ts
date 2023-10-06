import { ownerMap, ownersMap } from '$lib/server/mappers/owners';
import { expect, test } from 'vitest';
import Owner from '$test/data/OwnerData';

const owners = [{ user: Owner }, { test: Owner }];

test('ownerMap', () => {
	const result = ownerMap(Owner);

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
		]
	`);
});
