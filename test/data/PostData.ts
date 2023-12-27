import { user_basic_data_raw } from './UserData';
import { image_raw_data } from './PictureData';
import type { PostRaw } from '$lib/interfaces/PostRaw';


export const post_raw_data = {
	id: 1234567890123456n,
	rating: 5,
	comments: 0,
	published_at: new Date('2023-01-01T00:00:00.000Z'),
	updated_at: new Date('2023-01-01T00:00:00.000Z'),
	title: 'My First Post',
	body: [
		{
			type: 'text',
			text: 'This is my first post on my new blog.'
		}
	],
	user: user_basic_data_raw,
	image: image_raw_data,
	images: [{image: image_raw_data}]
} satisfies PostRaw;