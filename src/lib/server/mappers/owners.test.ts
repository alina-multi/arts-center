import { ownerMap, ownersMap } from '$lib/server/mappers/owners';
import { expect, test } from 'vitest';
import { user, UserData } from '$test/data/UserData';

const owners = [{ user }, { user }];

const result_owners = [UserData, UserData];

test('ownerMap', () => {
	const result = ownerMap(user);

	expect(result).toStrictEqual(UserData);
});

test('ownersMap', () => {
	const result = ownersMap(owners);
	expect(result).toStrictEqual(result_owners);
});
