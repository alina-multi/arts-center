import { commentMap, commentsMap } from './comments';
import { expect, test } from 'vitest';
import CommentData from '$test/data/CommentData';

const comments = [
	{
		...CommentData,
		id: 1
	},
	{
		...CommentData,
		id: 2
	},
	{
		...CommentData,
		id: 3,
		comment_id: 1
	},
	{
		...CommentData,
		id: 4,
		comment_id: 999
	}
];

test('commentMap', () => {
	const result = commentMap(CommentData);
	expect(result).toMatchInlineSnapshot(`
      {
        "created_at": "1975-08-19T23:15:30.000Z",
        "deleted_at": null,
        "id": 564n,
        "owner": {
          "country": null,
          "id": 12n,
          "name": "Test-test",
          "photo": null,
          "username": "serena10",
        },
        "rating": 1,
        "text": "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
        "updated_at": "1975-08-19T23:15:30.000Z",
      }
    `);
});

test('commentsMap', () => {
	const result = commentsMap(comments);
	expect(result).toMatchInlineSnapshot(`
  [
    {
      "answers": [
        {
          "created_at": 1975-08-19T23:15:30.000Z,
          "deleted_at": null,
          "id": 3,
          "owner": {
            "country": null,
            "id": 12n,
            "name": "Test-test",
            "photo": null,
            "username": "serena10",
          },
          "rating": 1,
          "text": "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
          "updated_at": 1975-08-19T23:15:30.000Z,
        },
      ],
      "created_at": 1975-08-19T23:15:30.000Z,
      "deleted_at": null,
      "id": 1,
      "owner": {
        "country": null,
        "id": 12n,
        "name": "Test-test",
        "photo": null,
        "username": "serena10",
      },
      "rating": 1,
      "text": "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
      "updated_at": 1975-08-19T23:15:30.000Z,
    },
    {
      "created_at": 1975-08-19T23:15:30.000Z,
      "deleted_at": null,
      "id": 2,
      "owner": {
        "country": null,
        "id": 12n,
        "name": "Test-test",
        "photo": null,
        "username": "serena10",
      },
      "rating": 1,
      "text": "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
      "updated_at": 1975-08-19T23:15:30.000Z,
    },
  ]
`);
});
