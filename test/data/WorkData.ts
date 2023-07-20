import type { Work } from '$lib/interfaces/Work';

export default {
	id: BigInt(39),
	published_at: new Date('2023-05-01T21:37:31.000Z'),
	rating: 1,
	comments: 1,
	hosts: 0,
	price: 1881,
	full: {},
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
	owners: [],
	votes: [],
	tags: [],
	details: null,
	width: null,
	height: null,
	length: null,
	year: null
} as Work;
