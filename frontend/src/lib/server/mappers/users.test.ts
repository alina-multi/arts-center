import { expect, test } from 'vitest';
import { userCountriesMap } from './users';

test('userCountriesMap', () => {
	const result = userCountriesMap(
		[
			{
				country: 'ua',
				_count: {
					country: 20
				}
			}
		],
		'uk'
	);
	expect(result).toStrictEqual([
		{
			title: 'Україна',
			count: 20,
			value: 'ua'
		}
	]);
});
