import { expect, test } from 'vitest';
import { postMap } from '$lib/server/mappers/post';
import { post_raw_data } from '$test/data/PostData';

test('postMap', () => {
	const result = postMap(post_raw_data);
	expect(result).toMatchInlineSnapshot(`
		{
		  "body": [
		    {
		      "text": "This is my first post on my new blog.",
		      "type": "text",
		    },
		  ],
		  "comments": 0,
		  "id": 1234567890123456n,
		  "image": {
		    "original": {
		      "height": 1024,
		      "src": "https://picsum.photos/id/5/400/600",
		      "width": 1280,
		    },
		    "sources": [
		      {
		        "srcset": "https://picsum.photos/id/2/400/600 300w, https://picsum.photos/id/4/400/600 600w",
		        "type": "image/webp",
		      },
		      {
		        "srcset": "https://picsum.photos/id/1/400/600 300w, https://picsum.photos/id/3/400/600 600w",
		        "type": "image/jpeg",
		      },
		    ],
		    "src": "https://picsum.photos/id/1/400/600",
		  },
		  "images": Map {
		    "11" => {
		      "original": {
		        "height": 1024,
		        "src": "https://picsum.photos/id/5/400/600",
		        "width": 1280,
		      },
		      "sources": [
		        {
		          "srcset": "https://picsum.photos/id/2/400/600 300w, https://picsum.photos/id/4/400/600 600w",
		          "type": "image/webp",
		        },
		        {
		          "srcset": "https://picsum.photos/id/1/400/600 300w, https://picsum.photos/id/3/400/600 600w",
		          "type": "image/jpeg",
		        },
		      ],
		      "src": "https://picsum.photos/id/1/400/600",
		    },
		  },
		  "owner": {
		    "country": undefined,
		    "id": 12n,
		    "name": "Name",
		    "photo": null,
		    "username": "username",
		    "verified_at": null,
		  },
		  "published_at": 2023-01-01T00:00:00.000Z,
		  "rating": 5,
		  "title": "My First Post",
		  "updated_at": 2023-01-01T00:00:00.000Z,
		}
	`);
});
