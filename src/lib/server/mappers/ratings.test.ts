import { expect, test } from 'vitest';
import { RatingData, user_rating } from '$test/data/RatingData';
import { ratingsMap } from './ratings';

const user_ratings = [user_rating];

test('ratingsMap', () => {
	const result = ratingsMap(user_ratings);
	expect(result).toStrictEqual([RatingData]);
});
