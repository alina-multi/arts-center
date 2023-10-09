import { commentMap, commentsMap } from './comments';
import { expect, test } from 'vitest';
import comment from '$test/data/CommentData';
import CommentData from '$test/data/CommentData';

const comments = [
	{
		...CommentData,
		id: 1n
	},
	{
		...CommentData,
		id: 2n
	},
	{
		...CommentData,
		id: 3n,
		comment_id: 1n
	},
	{
		...CommentData,
		id: 4n,
		comment_id: 999n
	}
];

test('commentMap', () => {
	const result = commentMap(comment);
	expect(result).toMatchInlineSnapshot(`
		{
		  "created_at": 1975-08-19T23:15:30.000Z,
		  "deleted_at": null,
		  "id": 11n,
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
		          "name": "Test",
		          "photo": null,
		          "username": "username",
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
		      "name": "Test",
		      "photo": null,
		      "username": "username",
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
		      "name": "Test",
		      "photo": null,
		      "username": "username",
		    },
		    "rating": 1,
		    "text": "At last the Mouse, sharply and very soon finished off the top of its mouth, and addressed her in an offended tone, and she very seldom followed it), and sometimes she scolded herself so severely as to the other, and making faces at him as he spoke, and then turned to the fifth bend, I think?' 'I.",
		    "updated_at": 1975-08-19T23:15:30.000Z,
		  },
		]
	`);
});
