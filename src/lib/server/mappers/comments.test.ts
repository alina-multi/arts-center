import { commentMap, commentsMap } from './comments';
import { expect, test } from 'vitest';
import { comment_raw_data, CommentData } from '$test/data/CommentData';

const comments = [
	{
		...comment_raw_data,
		id: 1n
	},
	{
		...comment_raw_data,
		id: 2n
	},
	{
		...comment_raw_data,
		id: 3n,
		comment_id: 1n
	},
	{
		...comment_raw_data,
		id: 4n,
		comment_id: 999n
	}
];

const comments_result = [
	{
		...CommentData,
		id: 1n,

		answers: [
			{
				...CommentData,
				id: 3n
			}
		]
	},
	{
		...CommentData,
		id: 2n
	}
];

test('commentMap', () => {
	const result = commentMap(comment_raw_data);
	expect(result).toStrictEqual(CommentData);
});

test('commentsMap', () => {
	const result = commentsMap(comments);
	expect(result).toStrictEqual(comments_result);
});
