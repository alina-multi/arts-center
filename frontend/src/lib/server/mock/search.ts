import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { userMap } from '$lib/server/mappers/users';
import { mockUsers, mockWorks } from '$lib/server/mock/data';
import type { UserFullRaw } from '$lib/interfaces/UserRaw';

const PAGE_SIZE = 20;

function jsonSafe<T>(value: T): T {
	return JSON.parse(
		JSON.stringify(value, (_key, item) => (typeof item === 'bigint' ? Number(item) : item))
	);
}

function pageOf<T>(items: T[], page: number) {
	const start = (Math.max(page, 1) - 1) * PAGE_SIZE;
	return items.slice(start, start + PAGE_SIZE);
}

function result<T>(items: T[], page: number) {
	return {
		hits: jsonSafe(pageOf(items, page)),
		totalHits: items.length
	};
}

export function mockSearch(searchable: string, query: string, page = 1) {
	const needle = query.trim().toLowerCase();
	const users = mockUsers.filter((user) => {
		return user.name.toLowerCase().includes(needle) || user.username.toLowerCase().includes(needle);
	});
	const works = mockWorks.filter((work) => {
		const title = work.titles.some((row) => row.title.toLowerCase().includes(needle));
		const owner = work.owners.some(
			(row) =>
				row.user.name.toLowerCase().includes(needle) ||
				row.user.username.toLowerCase().includes(needle)
		);
		return title || owner;
	});

	const userHits = users.map((user) => userMap(user as unknown as UserFullRaw, 'en'));
	const workHits = worksPreviewMap(works);

	if (searchable === 'users') return result(userHits, page);
	if (searchable === 'works') return result(workHits, page);
	return {
		users: result(userHits, page),
		works: result(workHits, page)
	};
}
