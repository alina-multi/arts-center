import { mockComments, mockPosts, mockTags, mockUsers, mockWorks } from '$lib/server/mock/data';
import type { MockPost, MockUser, MockWork } from '$lib/server/mock/data';
import type { ImageFolder, ImageRaw } from '$lib/interfaces/ImageRaw';
import { getDemoState } from '$lib/server/mock/session';
import type { DemoState, DemoWorkDraft } from '$lib/server/mock/session';

const TRENDING_RATING_CUTOFF = 20;

function sameId(left: unknown, right: unknown) {
	if (left === undefined || right === undefined || left === null || right === null) return false;
	try {
		return BigInt(left as string | number | bigint) === BigInt(right as string | number | bigint);
	} catch {
		return false;
	}
}

function matchScalar(value: unknown, filter: unknown): boolean {
	if (filter === undefined) return true;
	if (filter === null || typeof filter !== 'object' || filter instanceof Date) {
		return value === filter;
	}
	const rule = filter as Record<string, unknown>;
	if ('not' in rule) {
		if (rule.not === null) return value !== null && value !== undefined;
		return !matchScalar(value, rule.not);
	}
	if ('equals' in rule && !sameId(value, rule.equals) && value !== rule.equals) return false;
	if (
		('gte' in rule || 'gt' in rule || 'lte' in rule || 'lt' in rule) &&
		(value === null || value === undefined)
	) {
		return false;
	}
	if ('gte' in rule && !((value as number) >= (rule.gte as number))) return false;
	if ('gt' in rule && !((value as number) > (rule.gt as number))) return false;
	if ('lte' in rule && !((value as number) <= (rule.lte as number))) return false;
	if ('lt' in rule && !((value as number) < (rule.lt as number))) return false;
	if (
		'in' in rule &&
		!(rule.in as unknown[]).some((item) => sameId(value, item) || value === item)
	) {
		return false;
	}
	if (
		'notIn' in rule &&
		(rule.notIn as unknown[]).some((item) => value === item || sameId(value, item))
	) {
		return false;
	}
	return true;
}

function matchWork(work: MockWork, where: Record<string, unknown> = {}) {
	for (const [key, filter] of Object.entries(where)) {
		if (filter === undefined) continue;
		if (key === 'owners') {
			const spec = (filter as { some?: { user_id?: unknown } }).some;
			if (!spec) continue;
			const owns = work.owners.some((owner) =>
				spec.user_id === undefined ? true : sameId(owner.user.id, spec.user_id)
			);
			if (!owns) return false;
			continue;
		}
		if (key === 'tags') {
			const spec = (filter as { some?: { tag_id?: { equals?: unknown } | unknown } }).some;
			const tagId =
				spec?.tag_id && typeof spec.tag_id === 'object' && 'equals' in spec.tag_id
					? spec.tag_id.equals
					: spec?.tag_id;
			if (!work.tags.some((row) => sameId(row.tag.id, tagId))) return false;
			continue;
		}
		if (!matchScalar(work[key as keyof MockWork], filter)) return false;
	}
	return true;
}

function matchUser(user: MockUser, where: Record<string, unknown> = {}) {
	for (const [key, filter] of Object.entries(where)) {
		if (filter === undefined) continue;
		if (key === 'ratings') {
			const spec = (
				filter as {
					some?: { ratable_id?: { equals?: unknown }; ratable_type?: { equals?: unknown } };
				}
			).some;
			const tagId = spec?.ratable_id?.equals;
			const matches = user.ratings.some((rating) =>
				tagId === undefined ? true : sameId(rating.tag.id, tagId)
			);
			if (!matches) return false;
			continue;
		}
		if (!matchScalar(user[key as keyof MockUser], filter)) return false;
	}
	return true;
}

function matchPost(post: MockPost, where: Record<string, unknown> = {}) {
	for (const [key, filter] of Object.entries(where)) {
		if (filter === undefined) continue;
		if (key === 'id') {
			if (!sameId(post.id, filter) && !matchScalar(post.id, filter)) return false;
			continue;
		}
		if (key === 'user_id') {
			if (!sameId(post.user_id, filter)) return false;
			continue;
		}
		if (!matchScalar(post[key as keyof MockPost], filter)) return false;
	}
	return true;
}

function sortBy<T>(items: T[], orderBy: unknown): T[] {
	const orders = (Array.isArray(orderBy) ? orderBy : [orderBy]).filter(Boolean) as Record<
		string,
		string
	>[];
	const keys = orders.flatMap((order) => Object.entries(order));
	if (!keys.length) return items;
	return [...items].sort((left, right) => {
		for (const [key, direction] of keys) {
			const a = left[key as keyof T] as never;
			const b = right[key as keyof T] as never;
			if (a === b) continue;
			if (a == null) return 1;
			if (b == null) return -1;
			const compared = a > b ? 1 : -1;
			return direction === 'desc' ? -compared : compared;
		}
		return 0;
	});
}

function pageOf<T>(items: T[], page: number, perPage: number) {
	const start = Math.max(page, 0) * perPage;
	return items.slice(start, start + perPage);
}

export function mockWorksQuery(
	where: Record<string, unknown> = {},
	orderBy: unknown = {},
	page = 1,
	perPage = 20
) {
	const merged = {
		status: { gte: 40 },
		published_at: { lte: new Date() },
		deleted_at: null,
		...where
	};
	const works = sortBy(
		[...mockWorks.map(applyWorkOverlay), ...sessionWorks()].filter((work) => matchWork(work, merged)),
		orderBy
	);
	return pageOf(works, page - 1, perPage);
}

export function mockTrendingWorks() {
	return mockWorks
		.map(applyWorkOverlay)
		.filter(
			(work) =>
				work.deleted_at === null &&
				work.rating >= TRENDING_RATING_CUTOFF &&
				work.featured_at !== null &&
				work.featured_at <= new Date()
		)
		.slice(0, 6);
}

export function mockUsersQuery(
	where: Record<string, unknown> = {},
	orderBy: unknown = {},
	page = 1
) {
	const merged = {
		country: { not: 'ru' },
		approved_at: { not: null },
		deleted_at: null,
		...where
	};
	const users = sortBy(
		[...mockUsers, ...sessionUserList()]
			.filter((user) => matchUser(user, merged))
			.map(withSessionPhoto),
		orderBy
	);
	return pageOf(users, page - 1, 10);
}

export function mockUserGet(username: string) {
	const sessionUser = sessionUserList().find((item) => item.username === username);
	if (sessionUser) return withSessionPhoto(sessionUser);
	const user = mockUsers.find((item) => item.username === username);
	return user ? withSessionPhoto(user) : null;
}

export function mockUserCountries() {
	const counts = new Map<string, number>();
	for (const user of mockUsers) {
		if (user.deleted_at || user.country === 'ru') continue;
		counts.set(user.country, (counts.get(user.country) ?? 0) + 1);
	}
	return [...counts.entries()]
		.map(([country, count]) => ({ country, _count: { country: count } }))
		.sort((left, right) => right._count.country - left._count.country);
}

export function mockWorkGet(id: bigint | string) {
	const created = sessionWorks().find((work) => sameId(work.id, id));
	if (created) return created;
	const work = mockWorks.find((item) => sameId(item.id, id));
	return work ? applyWorkOverlay(work) : null;
}

export function mockPostsQuery(
	where: Record<string, unknown> = {},
	orderBy: unknown = {},
	page = 1
) {
	const merged = {
		deleted_at: null,
		published_at: { not: null },
		...where
	};
	const posts = sortBy(
		[...mockPosts, ...sessionPosts()].filter((post) => matchPost(post, merged)),
		orderBy
	);
	return pageOf(posts, page - 1, 10);
}

export function mockPostGet(id: string, where: Record<string, unknown> = {}) {
	return (
		[...sessionPosts(), ...mockPosts].find((post) => matchPost(post, { id, ...where })) ?? null
	);
}

export function mockUserPosts(userId: string | bigint) {
	return sortBy(
		[...mockPosts, ...sessionPosts()].filter(
			(post) => post.deleted_at === null && sameId(post.user_id, userId)
		),
		{ published_at: 'desc' }
	);
}

export function commentsFor(commentableId: bigint | string, commentableType: string) {
	const state = getDemoState();
	const hidden = new Set(state?.hiddenCommentIds || []);
	const mine = (state?.comments || [])
		.filter(
			(comment) =>
				!comment.deleted &&
				comment.commentableType === commentableType &&
				sameId(comment.commentableId, commentableId)
		)
		.map((comment) => sessionComment(comment));
	return [...mockComments, ...mine]
		.filter(
			(comment) =>
				comment.deleted_at === null &&
				!hidden.has(comment.id.toString()) &&
				comment.commentable_type === commentableType &&
				sameId(comment.commentable_id, commentableId)
		)
		.sort((left, right) => {
			if (left.depth !== right.depth) return left.depth - right.depth;
			return left.id < right.id ? -1 : 1;
		});
}

export function mockLatestComments() {
	return [...mockComments]
		.filter((comment) => comment.deleted_at === null && comment.commentable_type === 'work')
		.sort((left, right) => (left.id < right.id ? 1 : -1))
		.slice(0, 10)
		.map((comment) => ({
			...comment,
			work: mockWorks.find((work) => sameId(work.id, comment.commentable_id)) ?? null
		}));
}

export function mockCategories() {
	return mockTags;
}

function imageFromUpload(id: string, url: string, folder: ImageFolder): ImageRaw {
	return {
		id: BigInt(id),
		folder,
		variants: [],
		url
	};
}

function withSessionPhoto<T extends { username: string; photo: ImageRaw }>(user: T): T {
	const state = getDemoState();
	const image = state?.photoId ? state.images[state.photoId] : undefined;
	if (!image || user.username !== state?.account?.username) return user;
	return { ...user, photo: imageFromUpload(image.id, image.url, 'photos') };
}

function sessionUserList(): MockUser[] {
	const state = getDemoState();
	const account = state?.account;
	if (!account) return [];
	return [
		{
			id: BigInt(account.id),
			username: account.username,
			name: account.name,
			photo: blankPhoto(),
			country: (account.country || 'US').toLowerCase(),
			rating: 0,
			verified_at: new Date().toISOString(),
			approved_at: new Date().toISOString(),
			created_at: new Date(),
			updated_at: new Date(),
			deleted_at: null,
			bios: Object.entries(account.bios || {}).map(([language, text]) => ({ language, text })),
			ratings: []
		}
	];
}

function blankPhoto(): ImageRaw {
	return { id: BigInt(0), folder: 'photos', variants: [] };
}

function sessionComment(comment: {
	id: string;
	text: string;
	commentableId: string;
	commentableType: string;
	parentId: string | null;
	createdAt: string;
}): import('$lib/server/mock/data').MockComment {
	const owner = sessionUserList()[0];
	return {
		id: BigInt(comment.id),
		text: comment.text,
		rating: 0,
		deleted_at: null,
		created_at: new Date(comment.createdAt),
		updated_at: new Date(comment.createdAt),
		comment_id: comment.parentId ? BigInt(comment.parentId) : null,
		commentable_id: BigInt(comment.commentableId),
		commentable_type: comment.commentableType,
		owner,
		depth: comment.parentId ? 1 : 0
	};
}

function sessionPosts(): MockPost[] {
	const state = getDemoState();
	const owner = sessionUserList()[0];
	if (!state?.posts.length || !owner) return [];
	return state.posts
		.filter((post) => !post.deleted)
		.map((post) => {
			const image = post.imageId ? state.images[post.imageId] : undefined;
			const pictures = post.body
				.filter((block) => block.type === 'image')
				.map((block) => state.images[String(block.image_id)])
				.filter(Boolean)
				.map((picture) => ({ image: imageFromUpload(picture.id, picture.url, 'posts') }));
			return {
				id: BigInt(post.id),
				user_id: owner.id,
				rating: 0,
				comments: 0,
				featured: 0,
				published_at: post.publishedAt ? new Date(post.publishedAt) : null,
				updated_at: new Date(),
				deleted_at: null,
				title: post.title,
				body: post.body,
				language: post.language || 'en',
				image: image ? imageFromUpload(image.id, image.url, 'posts') : null,
				images: pictures,
				owner
			};
		});
}

function applyWorkOverlay(work: MockWork): MockWork {
	const state = getDemoState();
	const extra = state?.works[work.id.toString()];
	const photoWork = {
		...work,
		owners: work.owners.map((owner) => ({ user: withSessionPhoto(owner.user) }))
	};
	if (!state || !extra?.imageIds.length) return photoWork;
	return withUploadedImages(photoWork, state, extra.imageIds, extra.mainImageId);
}

function sessionWorks(): MockWork[] {
	const state = getDemoState();
	const owner = sessionUserList()[0];
	if (!state?.created.length || !owner) return [];
	return state.created
		.filter((draft) => !draft.deleted)
		.map((draft) => draftToWork(draft, state, owner));
}

function draftToWork(draft: DemoWorkDraft, state: DemoState, owner: MockUser): MockWork {
	const base: MockWork = {
		id: BigInt(draft.id),
		published_at: draft.publishedAt ? new Date(draft.publishedAt) : null,
		featured_at: null,
		updated_at: new Date(),
		deleted_at: null,
		status: draft.publishedAt ? 40 : 0,
		rating: 0,
		comments: 0,
		hosts: 0,
		price: 0,
		preview: imageFromUpload(draft.mainImageId || draft.imageIds[0] || '0', '', 'preview'),
		full: imageFromUpload(draft.mainImageId || draft.imageIds[0] || '0', '', 'works'),
		images: [],
		titles: draft.titles?.length
			? draft.titles
			: [
					{
						title: draft.title,
						description: 'Uploaded in the demo studio.',
						alt: draft.title,
						language: 'en'
					},
					{
						title: 'Нова робота',
						description: 'Завантажено в демо-студії.',
						alt: 'Нова робота',
						language: 'uk'
					}
				],
		owners: [{ user: withSessionPhoto(owner) }],
		votes: [],
		tags: [
			{
				tag: mockTags.find((tag) => tag.id.toString() === String(draft.tagId || '')) || mockTags[0]
			}
		],
		details: {
			year: draft.year ?? new Date().getFullYear(),
			width: draft.width ?? 80,
			height: draft.height ?? 100,
			length: draft.length ?? null
		}
	};
	return withUploadedImages(base, state, draft.imageIds, draft.mainImageId);
}

function withUploadedImages(
	work: MockWork,
	state: DemoState,
	imageIds: string[],
	mainImageId?: string
): MockWork {
	const uploaded = imageIds
		.map((id) => state.images[id])
		.filter((image) => image)
		.map((image) => ({ image: imageFromUpload(image.id, image.url, 'works') }));
	const main = state.images[mainImageId || imageIds.at(-1) || ''];
	const mainImage = main ? imageFromUpload(main.id, main.url, 'works') : work.preview;
	return {
		...work,
		preview: main ? imageFromUpload(main.id, main.url, 'preview') : work.preview,
		full: mainImage,
		images: [...work.images, ...uploaded]
	};
}

export function mockOwnerWorks(ownerId: bigint, excludeWorkId: bigint) {
	return mockWorksQuery(
		{
			owners: { some: { user_id: ownerId } },
			id: { not: excludeWorkId }
		},
		{ published_at: 'desc' },
		1,
		6
	);
}
