import { error } from '@sveltejs/kit';
import { mockTags, mockUsers } from '$lib/server/mock/data';
import { getDemoState, updateDemoState } from '$lib/server/mock/session';
import type { DemoAccount, DemoState, DemoThread } from '$lib/server/mock/session';
import { pictureFromUrl, pictureMap } from '$lib/server/mappers/pictures';
import { userMap } from '$lib/server/mappers/users';
import { worksPreviewMap } from '$lib/server/mappers/gallery';
import { mockWorkGet } from '$lib/server/mock/read';

function nextId() {
	return `${Date.now()}${Math.floor(Math.random() * 1000)}`;
}

function accountOf(state: DemoState): DemoAccount {
	if (!state.account) error(401, 'Sign in to the demo first');
	return state.account;
}

function notify(state: DemoState, type: string, data: Record<string, unknown>) {
	state.notifications.unshift({
		id: nextId(),
		type,
		readAt: null,
		createdAt: new Date().toISOString(),
		data
	});
}

export function demoProfile() {
	const account = getDemoState()?.account;
	if (!account) error(401, 'Sign in to the demo first');
	return {
		data: {
			name: account.name,
			email: account.email,
			country: account.country,
			username: account.username,
			bios: account.bios,
			email_verified_at: null
		}
	};
}

export function saveDemoProfile(input: {
	name?: unknown;
	email?: unknown;
	country?: unknown;
	bios?: Record<string, unknown>;
}) {
	return updateDemoState((state) => {
		const account = accountOf(state);
		if (input.name) account.name = String(input.name);
		if (input.email) account.email = String(input.email).trim().toLowerCase();
		if (input.country) account.country = String(input.country);
		if (input.bios) {
			account.bios = Object.fromEntries(
				Object.entries(input.bios).map(([language, text]) => [language, String(text ?? '')])
			);
		}
		return { ok: true };
	});
}

export function saveDemoIntent(intent: string) {
	const allowed = ['explore', 'buy', 'sell', 'network'];
	if (!allowed.includes(intent)) error(400, 'Unknown intent');
	return updateDemoState((state) => {
		accountOf(state).intent = intent as DemoAccount['intent'];
		return { ok: true };
	});
}

function findCreated(state: DemoState, id: string) {
	const work = state.created.find((item) => item.id === id && !item.deleted);
	if (!work) error(404, 'Work not found');
	return work;
}

export function saveDemoWorkDetails(
	id: string,
	input: {
		titles?: { title?: string; description?: string; language?: string }[];
		category?: string[] | string;
		title?: unknown;
		description?: unknown;
		language?: unknown;
	}
) {
	return updateDemoState((state) => {
		const work = findCreated(state, id);
		if (Array.isArray(input.titles) && input.titles.length) {
			work.titles = input.titles.map((title) => ({
				title: String(title.title || work.title),
				description: title.description ? String(title.description) : null,
				alt: String(title.title || work.title),
				language: String(title.language || 'en')
			}));
			work.title = work.titles[0]?.title || work.title;
		} else if (input.title) {
			const language = String(input.language || 'en');
			const titles = work.titles || [];
			const existing = titles.find((title) => title.language === language);
			if (existing) {
				existing.title = String(input.title);
				existing.description = input.description ? String(input.description) : existing.description;
			} else {
				titles.push({
					title: String(input.title),
					description: input.description ? String(input.description) : null,
					alt: String(input.title),
					language
				});
			}
			work.titles = titles;
			work.title = String(input.title);
		}
		const category = Array.isArray(input.category) ? input.category[0] : input.category;
		if (category) work.tagId = String(category).split(',')[0];
		return { ok: true, message: 'Saved', work: { id: Number(work.id), titles: work.titles } };
	});
}

export function publishDemoWork(id: string, publishedAt?: unknown) {
	return updateDemoState((state) => {
		const work = findCreated(state, id);
		work.publishedAt = publishedAt ? String(publishedAt) : new Date().toISOString();
		return { ok: true };
	});
}

export function unpublishDemoWork(id: string) {
	return updateDemoState((state) => {
		const work = findCreated(state, id);
		work.publishedAt = null;
		return { ok: true };
	});
}

export function deleteDemoWork(id: string) {
	return updateDemoState((state) => {
		const work = findCreated(state, id);
		work.deleted = true;
		return { ok: true };
	});
}

export function addDemoComment(input: {
	commentable_id: unknown;
	commentable_type: unknown;
	text: unknown;
	comment_id?: unknown;
}) {
	return updateDemoState((state) => {
		const account = accountOf(state);
		const comment = {
			id: nextId(),
			text: String(input.text || ''),
			commentableId: String(input.commentable_id),
			commentableType: String(input.commentable_type || 'work'),
			parentId: input.comment_id ? String(input.comment_id) : null,
			createdAt: new Date().toISOString()
		};
		state.comments.push(comment);
		notify(state, 'App\\Notifications\\NewWorkComment', {
			username: account.username,
			name: account.name,
			text: comment.text,
			work_id: Number(comment.commentableId),
			work_titles: [{ title: 'Work', language: 'en' }],
			comment_id: Number(comment.id)
		});
		return { id: Number(comment.id), text: comment.text };
	});
}

export function editDemoComment(id: string, text: unknown) {
	return updateDemoState((state) => {
		const comment = state.comments.find((item) => item.id === id);
		if (!comment) error(404, 'Comment not found');
		comment.text = String(text || '');
		return { ok: true, id: Number(id), text: comment.text };
	});
}

export function deleteDemoComment(id: string) {
	return updateDemoState((state) => {
		const comment = state.comments.find((item) => item.id === id);
		if (comment) comment.deleted = true;
		else state.hiddenCommentIds.push(id);
		return { ok: true };
	});
}

export function setDemoVote(input: { vote: unknown; votable_type: unknown; votable_id: unknown }, remove = false) {
	return updateDemoState((state) => {
		const key = `${input.votable_type}:${input.votable_id}`;
		if (remove) delete state.votes[key];
		else state.votes[key] = Number(input.vote) === -1 ? -1 : 1;
		return { ok: true };
	});
}

export function setDemoFollow(userId: unknown, follow: boolean) {
	return updateDemoState((state) => {
		const id = String(userId);
		state.follows = state.follows.filter((item) => item !== id);
		if (follow) {
			state.follows.push(id);
			const person = mockUsers.find((user) => user.id.toString() === id);
			notify(state, 'App\\Notifications\\NewFollower', {
				username: person?.username || id,
				name: person?.name || 'Artist'
			});
		}
		return { ok: true };
	});
}

export function setDemoBlock(userId: unknown, block: boolean) {
	return updateDemoState((state) => {
		const id = String(userId);
		state.blocks = state.blocks.filter((item) => item !== id);
		if (block) state.blocks.push(id);
		return { ok: true };
	});
}

export function saveDemoFavorite(input: { work_id: unknown; folder_id?: unknown; folder_title?: unknown }) {
	return updateDemoState((state) => {
		const workId = String(input.work_id);
		let folder = state.folders.find((item) => item.id === String(input.folder_id || ''));
		if (!folder && input.folder_title) {
			folder = { id: nextId(), title: String(input.folder_title), workIds: [] };
			state.folders.push(folder);
		}
		if (!folder) error(400, 'Choose a folder');
		if (!folder.workIds.includes(workId)) folder.workIds.push(workId);
		return { id: Number(folder.id), title: folder.title };
	});
}

export function removeDemoFavorite(workId: unknown) {
	return updateDemoState((state) => {
		const id = String(workId);
		for (const folder of state.folders) {
			folder.workIds = folder.workIds.filter((work) => work !== id);
		}
		return { ok: true };
	});
}

export function renameDemoFolder(id: string, title: unknown) {
	return updateDemoState((state) => {
		const folder = state.folders.find((item) => item.id === id);
		if (!folder) error(404, 'Folder not found');
		folder.title = String(title || folder.title);
		return { ok: true };
	});
}

export function deleteDemoFolder(id: string) {
	return updateDemoState((state) => {
		state.folders = state.folders.filter((item) => item.id !== id);
		return { ok: true };
	});
}

export function demoFolders() {
	return getDemoState()?.folders.map((folder) => ({ id: Number(folder.id), title: folder.title })) || [];
}

export function demoFolder(id: string) {
	const folder = getDemoState()?.folders.find((item) => item.id === id);
	if (!folder) error(404, 'Folder not found');
	const works = folder.workIds.map((workId) => mockWorkGet(workId)).filter(Boolean);
	return {
		id: Number(folder.id),
		title: folder.title,
		works: worksPreviewMap(works)
	};
}

function personById(id: string, lang: string) {
	const user = mockUsers.find((item) => item.id.toString() === id);
	if (!user) return null;
	return userMap(user as never, lang as 'en' | 'uk');
}

export function demoFollowing(lang: string) {
	const ids = getDemoState()?.follows || [];
	return ids.map((id) => personById(id, lang)).filter(Boolean);
}

export function demoBlocked(lang: string) {
	const ids = getDemoState()?.blocks || [];
	return ids.map((id) => personById(id, lang)).filter(Boolean);
}

export function createDemoPost() {
	return updateDemoState((state) => {
		const post = {
			id: nextId(),
			title: '',
			body: [],
			language: 'en',
			publishedAt: null
		};
		state.posts.unshift(post);
		return { id: Number(post.id) };
	});
}

export function saveDemoPost(
	id: string,
	input: { title?: unknown; body?: DemoState['posts'][number]['body']; published_at?: unknown; language?: unknown; image_id?: unknown }
) {
	return updateDemoState((state) => {
		const post = state.posts.find((item) => item.id === id);
		if (!post) error(404, 'Post not found');
		if (input.title !== undefined) post.title = String(input.title || '');
		if (input.body) post.body = input.body;
		if (input.language) post.language = String(input.language);
		if ('published_at' in input) post.publishedAt = input.published_at ? String(input.published_at) : null;
		if (input.image_id) post.imageId = String(input.image_id);
		return { ok: true };
	});
}

function otherUser(id: string) {
	const user = mockUsers.find((item) => item.id.toString() === id) || mockUsers[0];
	return {
		id: Number(user.id),
		username: user.username,
		name: user.name,
		photo: pictureMap(user.photo)
	};
}

function threadView(thread: DemoThread, state: DemoState) {
	const account = accountOf(state);
	const mine = {
		id: BigInt(account.id),
		username: account.username,
		name: account.name,
		photo: state.photoId && state.images[state.photoId] ? pictureFromUrl(state.images[state.photoId].url) : null
	};
	const other = otherUser(thread.participantId);
	return {
		id: Number(thread.id),
		title: thread.title,
		unread_messages: 0,
		last_message: thread.messages.filter((message) => !message.deleted).at(-1)?.body || '',
		participants: [{ user: other }, { user: mine }],
		messages: thread.messages
			.filter((message) => !message.deleted)
			.map((message) => ({
				id: Number(message.id),
				message: message.body,
				created_at: message.createdAt,
				user: message.mine ? mine : other
			}))
	};
}

export function listDemoThreads() {
	const state = getDemoState();
	if (!state?.account) return { data: [] };
	return { data: state.threads.map((thread) => threadView(thread, state)) };
}

export function getDemoThread(id: string) {
	const state = getDemoState();
	const thread = state?.threads.find((item) => item.id === id);
	if (!state || !thread) error(404, 'Conversation not found');
	return threadView(thread, state);
}

export function startDemoThread(participantId: unknown, title = 'empty') {
	return updateDemoState((state) => {
		const existing = state.threads.find((thread) => thread.participantId === String(participantId));
		if (existing) return { id: Number(existing.id) };
		const thread: DemoThread = {
			id: nextId(),
			participantId: String(participantId),
			title: String(title || 'empty'),
			messages: []
		};
		state.threads.unshift(thread);
		return { id: Number(thread.id) };
	});
}

export function addDemoMessage(threadId: string, body: unknown) {
	return updateDemoState((state) => {
		const thread = state.threads.find((item) => item.id === threadId);
		if (!thread) error(404, 'Conversation not found');
		const message = {
			id: nextId(),
			body: String(body || ''),
			mine: true,
			userId: accountOf(state).id,
			createdAt: new Date().toISOString()
		};
		thread.messages.push(message);
		const other = otherUser(thread.participantId);
		notify(state, 'App\\Notifications\\NewMessage', {
			user: other,
			thread_id: Number(thread.id),
			message: message.body
		});
		return { id: Number(message.id), success: true };
	});
}

export function editDemoMessage(threadId: string, messageId: string, body: unknown) {
	return updateDemoState((state) => {
		const message = state.threads
			.find((thread) => thread.id === threadId)
			?.messages.find((item) => item.id === messageId);
		if (!message) error(404, 'Message not found');
		message.body = String(body || '');
		return { ok: true };
	});
}

export function deleteDemoMessage(threadId: string, messageId: string) {
	return updateDemoState((state) => {
		const message = state.threads
			.find((thread) => thread.id === threadId)
			?.messages.find((item) => item.id === messageId);
		if (!message) error(404, 'Message not found');
		message.deleted = true;
		return { ok: true };
	});
}

export function demoNotifications() {
	const notes = getDemoState()?.notifications || [];
	return notes.map((note) => ({
		id: note.id,
		type: note.type,
		read_at: note.readAt,
		created_at: note.createdAt,
		data: note.data,
		...note.data
	}));
}

export function markDemoNotificationsRead() {
	return updateDemoState((state) => {
		const now = new Date().toISOString();
		for (const note of state.notifications) note.readAt = note.readAt || now;
		return { ok: true };
	});
}

export function demoPreferences() {
	return { preferences: getDemoState()?.preferences || [] };
}

export function saveDemoPreferences(preferences: { type: number; channel: number }[]) {
	return updateDemoState((state) => {
		state.preferences = preferences;
		return { ok: true };
	});
}

export function saveDemoFeedback(body: unknown) {
	return updateDemoState((state) => {
		state.feedback.push(body);
		return { ok: true };
	});
}

export function saveDemoDonation(input: { username?: unknown; quantity?: unknown }) {
	return updateDemoState((state) => {
		state.donations.unshift({
			id: nextId(),
			username: String(input.username || ''),
			quantity: Number(input.quantity || 1),
			createdAt: new Date().toISOString()
		});
		return { ok: true, saved: true };
	});
}

export function demoDonations() {
	return (getDemoState()?.donations || []).map((donation) => ({
		id: Number(donation.id),
		type: 1,
		created_at: donation.createdAt,
		amount_net: donation.quantity * 5,
		message: donation.username
	}));
}

export function tagById(id?: string) {
	return mockTags.find((tag) => tag.id.toString() === String(id || '')) || mockTags[0];
}
