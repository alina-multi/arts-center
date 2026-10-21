import type { ImageFolder, ImageRaw } from '$lib/interfaces/ImageRaw';
import type { CategoryRaw } from '$lib/interfaces/CategoryRaw';

export interface MockUser {
	id: bigint;
	username: string;
	name: string;
	photo: ImageRaw;
	country: string;
	rating: number;
	verified_at: string | null;
	approved_at: string | null;
	created_at: Date;
	updated_at: Date;
	deleted_at: Date | null;
	bios: { text: string; language: string }[];
	ratings: {
		rating: number;
		language: string;
		tag: { id: bigint; titles: { title: string; language: string }[] };
	}[];
}

export interface MockWork {
	id: bigint;
	published_at: Date | null;
	featured_at: Date | null;
	updated_at: Date;
	deleted_at: Date | null;
	status: number;
	rating: number;
	comments: number;
	hosts: number;
	price: number;
	preview: ImageRaw;
	full: ImageRaw;
	images: { image: ImageRaw }[];
	titles: { title: string; description: string | null; alt: string | null; language: string }[];
	owners: { user: MockUser }[];
	votes: { user: MockUser }[];
	tags: { tag: CategoryRaw }[];
	details: {
		year: number | null;
		width: number | null;
		height: number | null;
		length: number | null;
	};
}

export interface MockPost {
	id: bigint;
	user_id: bigint;
	rating: number;
	comments: number;
	featured: number;
	published_at: Date | null;
	updated_at: Date;
	deleted_at: Date | null;
	title: string;
	body: ({ type: 'text'; text: string } | { type: 'image'; image_id: number })[];
	language: string;
	image: ImageRaw | null;
	images: { image: ImageRaw }[];
	owner: MockUser;
}

export interface MockComment {
	id: bigint;
	text: string;
	rating: number;
	deleted_at: Date | null;
	created_at: Date;
	updated_at: Date;
	comment_id: bigint | null;
	commentable_id: bigint;
	commentable_type: string;
	owner: MockUser;
	depth: number;
}

function image(id: number, folder: ImageFolder): ImageRaw {
	return {
		id: BigInt(id),
		folder,
		variants: [
			{
				id: BigInt(id),
				extension: 'jpg',
				width: 400,
				height: 600,
				size: 80000,
				original: false
			},
			{
				id: BigInt(id),
				extension: 'webp',
				width: 400,
				height: 600,
				size: 40000,
				original: false
			},
			{
				id: BigInt(id + 1),
				extension: 'jpg',
				width: 800,
				height: 1200,
				size: 160000,
				original: true
			}
		]
	};
}

function tag(id: number, count: number, en: string, uk: string): CategoryRaw {
	return {
		id: BigInt(id),
		count,
		deleted_at: null,
		titles: [
			{ title: en, language: 'en' },
			{ title: uk, language: 'uk' }
		]
	};
}

export const mockTags: CategoryRaw[] = [
	tag(1, 3, 'Painting', 'Живопис'),
	tag(2, 3, 'Sculpture', 'Скульптура'),
	tag(3, 2, 'Photography', 'Фотографія')
];

const painting = mockTags[0];
const sculpture = mockTags[1];
const photography = mockTags[2];

function user(input: {
	id: number;
	username: string;
	name: string;
	country: string;
	rating: number;
	photoId: number;
	created_at: string;
	bioEn: string;
	bioUk: string;
	tag: CategoryRaw;
	tagRating: number;
}): MockUser {
	return {
		id: BigInt(input.id),
		username: input.username,
		name: input.name,
		photo: image(input.photoId, 'photos'),
		country: input.country,
		rating: input.rating,
		verified_at: '2024-01-15T00:00:00.000Z',
		approved_at: '2024-01-10T00:00:00.000Z',
		created_at: new Date(input.created_at),
		updated_at: new Date('2026-01-01T00:00:00.000Z'),
		deleted_at: null,
		bios: [
			{ text: input.bioEn, language: 'en' },
			{ text: input.bioUk, language: 'uk' }
		],
		ratings: [
			{
				rating: input.tagRating,
				language: 'zz',
				tag: { id: input.tag.id, titles: input.tag.titles }
			}
		]
	};
}

export const mockUsers: MockUser[] = [
	user({
		id: 1,
		username: 'maya-chen',
		name: 'Maya Chen',
		country: 'ua',
		rating: 86,
		photoId: 64,
		created_at: '2022-03-01T00:00:00.000Z',
		bioEn: 'Painter working with harbor light, quiet rooms, and large fields of color.',
		bioUk: 'Художниця, яка працює зі світлом гавані, тихими кімнатами й великими полями кольору.',
		tag: painting,
		tagRating: 90
	}),
	user({
		id: 2,
		username: 'leo-berg',
		name: 'Leo Berg',
		country: 'de',
		rating: 64,
		photoId: 91,
		created_at: '2023-06-12T00:00:00.000Z',
		bioEn: 'Sculptor of clay vessels and small bronze studies.',
		bioUk: 'Скульптор глиняних посудин і невеликих бронзових етюдів.',
		tag: sculpture,
		tagRating: 70
	}),
	user({
		id: 3,
		username: 'ada-okonkwo',
		name: 'Ada Okonkwo',
		country: 'ng',
		rating: 41,
		photoId: 102,
		created_at: '2024-02-02T00:00:00.000Z',
		bioEn: 'Photographer of night markets and the hour after they close.',
		bioUk: 'Фотографка нічних ринків і години після того, як вони зачиняються.',
		tag: photography,
		tagRating: 55
	}),
	user({
		id: 4,
		username: 'noor-ali',
		name: 'Noor Ali',
		country: 'fr',
		rating: 28,
		photoId: 177,
		created_at: '2025-04-20T00:00:00.000Z',
		bioEn: 'Makes paper sculpture and walks river paths with a camera.',
		bioUk: 'Робить паперову скульптуру і знімає річкові стежки.',
		tag: photography,
		tagRating: 30
	})
];

const [maya, leo, ada, noor] = mockUsers;
const featuredAt = new Date('2026-02-01T00:00:00.000Z');

function work(input: {
	id: number;
	owner: MockUser;
	tag: CategoryRaw;
	rating: number;
	comments: number;
	price: number;
	year: number;
	imageId: number;
	published_at: string;
	en: string;
	uk: string;
	description: string;
}): MockWork {
	const preview = image(input.imageId, 'preview');
	const full = image(input.imageId + 2, 'works');
	return {
		id: BigInt(input.id),
		published_at: new Date(input.published_at),
		featured_at: featuredAt,
		updated_at: new Date(input.published_at),
		deleted_at: null,
		status: 40,
		rating: input.rating,
		comments: input.comments,
		hosts: 120 + input.id,
		price: input.price,
		preview,
		full,
		images: [{ image: full }, { image: preview }],
		titles: [
			{
				title: input.en,
				description: input.description,
				alt: input.en,
				language: 'en'
			},
			{
				title: input.uk,
				description: input.description,
				alt: input.uk,
				language: 'uk'
			}
		],
		owners: [{ user: input.owner }],
		votes: [{ user: input.owner }],
		tags: [{ tag: input.tag }],
		details: { year: input.year, width: 80, height: 100, length: null }
	};
}

export const mockWorks: MockWork[] = [
	work({
		id: 1,
		owner: maya,
		tag: painting,
		rating: 48,
		comments: 2,
		price: 0,
		year: 2024,
		imageId: 30,
		published_at: '2026-03-01T00:00:00.000Z',
		en: 'Harbor Light',
		uk: 'Світло гавані',
		description: 'A wide view of a harbor just after sunrise.'
	}),
	work({
		id: 2,
		owner: leo,
		tag: sculpture,
		rating: 36,
		comments: 1,
		price: 12000,
		year: 2023,
		imageId: 40,
		published_at: '2026-02-18T00:00:00.000Z',
		en: 'Clay Vessel',
		uk: 'Глиняна посудина',
		description: 'A hand-built vessel with a broken rim left as it came from the kiln.'
	}),
	work({
		id: 3,
		owner: ada,
		tag: photography,
		rating: 22,
		comments: 1,
		price: 0,
		year: 2025,
		imageId: 50,
		published_at: '2026-01-20T00:00:00.000Z',
		en: 'Night Market',
		uk: 'Нічний ринок',
		description: 'Stalls closing, one light still on.'
	}),
	work({
		id: 4,
		owner: maya,
		tag: painting,
		rating: 8,
		comments: 0,
		price: 0,
		year: 2025,
		imageId: 60,
		published_at: '2026-04-02T00:00:00.000Z',
		en: 'Studio Sketch',
		uk: 'Етюд у студії',
		description: 'A small study made between larger paintings.'
	}),
	work({
		id: 5,
		owner: leo,
		tag: sculpture,
		rating: 12,
		comments: 0,
		price: 5000,
		year: 2022,
		imageId: 70,
		published_at: '2025-11-11T00:00:00.000Z',
		en: 'Bronze Study',
		uk: 'Бронзовий етюд',
		description: 'A palm-sized study for a larger figure.'
	}),
	work({
		id: 6,
		owner: noor,
		tag: photography,
		rating: 55,
		comments: 1,
		price: 0,
		year: 2024,
		imageId: 80,
		published_at: '2026-03-22T00:00:00.000Z',
		en: 'River Path',
		uk: 'Річкова стежка',
		description: 'A path along the river in late afternoon.'
	}),
	work({
		id: 7,
		owner: ada,
		tag: painting,
		rating: 31,
		comments: 0,
		price: 8000,
		year: 2021,
		imageId: 90,
		published_at: '2025-09-09T00:00:00.000Z',
		en: 'Window Seat',
		uk: 'Місце біля вікна',
		description: 'The chair by the studio window, late winter.'
	}),
	work({
		id: 8,
		owner: noor,
		tag: sculpture,
		rating: 6,
		comments: 0,
		price: 0,
		year: 2026,
		imageId: 110,
		published_at: '2026-05-01T00:00:00.000Z',
		en: 'Paper Fold',
		uk: 'Паперовий згин',
		description: 'Folded paper held just long enough to cast a shadow.'
	})
];

function post(input: {
	id: number;
	owner: MockUser;
	language: 'en' | 'uk';
	title: string;
	text: string;
	imageId: number;
	published_at: string;
	featured?: number;
}): MockPost {
	const picture = image(input.imageId, 'grids');
	return {
		id: BigInt(input.id),
		user_id: input.owner.id,
		rating: 12,
		comments: input.id === 1 ? 1 : 0,
		featured: input.featured ?? 1,
		published_at: new Date(input.published_at),
		updated_at: new Date(input.published_at),
		deleted_at: null,
		title: input.title,
		body: [
			{ type: 'text', text: `<p>${input.text}</p>` },
			{ type: 'image', image_id: input.imageId }
		],
		language: input.language,
		image: picture,
		images: [{ image: picture }],
		owner: input.owner
	};
}

export const mockPosts: MockPost[] = [
	post({
		id: 1,
		owner: maya,
		language: 'en',
		title: 'On looking slowly',
		text: 'Most of the paintings start as an hour of looking before any color goes down.',
		imageId: 120,
		published_at: '2026-03-12T00:00:00.000Z'
	}),
	post({
		id: 2,
		owner: leo,
		language: 'uk',
		title: 'Про глину',
		text: 'Глина пам’ятає температуру рук довше, ніж здається.',
		imageId: 130,
		published_at: '2026-02-02T00:00:00.000Z'
	}),
	post({
		id: 3,
		owner: ada,
		language: 'en',
		title: 'After the market closes',
		text: 'The interesting pictures are usually ten minutes after the last stall packs up.',
		imageId: 140,
		published_at: '2026-01-28T00:00:00.000Z'
	}),
	post({
		id: 4,
		owner: noor,
		language: 'uk',
		title: 'Стежка',
		text: 'Я повертаюся на ту саму стежку, доки світло не стане іншим.',
		imageId: 150,
		published_at: '2026-04-04T00:00:00.000Z'
	})
];

export const mockComments: MockComment[] = [
	{
		id: 1n,
		text: 'The light on the water is the whole painting.',
		rating: 3,
		deleted_at: null,
		created_at: new Date('2026-03-02T00:00:00.000Z'),
		updated_at: new Date('2026-03-02T00:00:00.000Z'),
		comment_id: null,
		commentable_id: 1n,
		commentable_type: 'work',
		owner: leo,
		depth: 0
	},
	{
		id: 2n,
		text: 'Thank you — that band of color took the longest.',
		rating: 1,
		deleted_at: null,
		created_at: new Date('2026-03-03T00:00:00.000Z'),
		updated_at: new Date('2026-03-03T00:00:00.000Z'),
		comment_id: 1n,
		commentable_id: 1n,
		commentable_type: 'work',
		owner: maya,
		depth: 1
	},
	{
		id: 3n,
		text: 'This is the quietest market picture I have seen.',
		rating: 2,
		deleted_at: null,
		created_at: new Date('2026-01-21T00:00:00.000Z'),
		updated_at: new Date('2026-01-21T00:00:00.000Z'),
		comment_id: null,
		commentable_id: 3n,
		commentable_type: 'work',
		owner: noor,
		depth: 0
	},
	{
		id: 4n,
		text: 'The rim makes the piece.',
		rating: 2,
		deleted_at: null,
		created_at: new Date('2026-02-19T00:00:00.000Z'),
		updated_at: new Date('2026-02-19T00:00:00.000Z'),
		comment_id: null,
		commentable_id: 2n,
		commentable_type: 'work',
		owner: ada,
		depth: 0
	},
	{
		id: 5n,
		text: 'I keep coming back to this path.',
		rating: 1,
		deleted_at: null,
		created_at: new Date('2026-03-23T00:00:00.000Z'),
		updated_at: new Date('2026-03-23T00:00:00.000Z'),
		comment_id: null,
		commentable_id: 6n,
		commentable_type: 'work',
		owner: maya,
		depth: 0
	},
	{
		id: 6n,
		text: 'An hour of looking sounds exactly right.',
		rating: 1,
		deleted_at: null,
		created_at: new Date('2026-03-13T00:00:00.000Z'),
		updated_at: new Date('2026-03-13T00:00:00.000Z'),
		comment_id: null,
		commentable_id: 1n,
		commentable_type: 'post',
		owner: ada,
		depth: 0
	}
];
