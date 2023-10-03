import type { Work } from '$lib/interfaces/Work';
import PictureData from '$test/data/PictureData';
import UserData from '$test/data/UserData';

export default {
	id: BigInt(1),
	published_at: new Date('2023-05-01T21:37:31.000Z'),
	rating: 1,
	comments: 1,
	hosts: 0,
	price: 1881,
	full: PictureData,
	images: [],
	titles: [
		{
			language: 'uk',
			title: 'Тестовий заголовок'
		},
		{
			language: 'en',
			title: 'Test header'
		}
	],
	owners: [UserData],
	votes: [],
	tags: [],
	details: null,
	width: null,
	height: null,
	length: null,
	year: null
} as Work;
