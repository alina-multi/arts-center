import { ownerMap, ownersMap } from '$lib/server/mappers/owners';
import { expect, test } from 'vitest';
import { user_basic_data_raw, UserBasicData } from '$test/data/UserData';

const owners = [{ user: user_basic_data_raw }];

const result_owners = [UserBasicData];

test('ownerMap', () => {
	const result = ownerMap(user_basic_data_raw);

	expect(result).toStrictEqual(UserBasicData);
});

test('ownersMap', () => {
	const result = ownersMap(owners);
	expect(result).toStrictEqual(result_owners);
});
