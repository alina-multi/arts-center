import { AsyncLocalStorage } from 'node:async_hooks';
import { mkdir, readFile, writeFile } from 'node:fs/promises';
import path from 'node:path';
import { error } from '@sveltejs/kit';
import type { Cookies } from '@sveltejs/kit';

export const DEMO_COOKIE = 'demo_session';
const DEMO_MAX_AGE = 60 * 60 * 24 * 30;
const MAX_BYTES = 8 * 1024 * 1024;

const ALLOWED_TYPES: Record<string, string> = {
	'image/jpeg': 'jpg',
	'image/png': 'png',
	'image/webp': 'webp'
};

export interface DemoImage {
	id: string;
	url: string;
	contentType: string;
}

export interface DemoWorkDraft {
	id: string;
	title: string;
	imageIds: string[];
	mainImageId?: string;
	titles?: { title: string; description: string | null; alt: string | null; language: string }[];
	publishedAt?: string | null;
	deleted?: boolean;
	tagId?: string;
	price?: number;
	year?: number | null;
	width?: number | null;
	height?: number | null;
	length?: number | null;
}

export interface DemoWorkOverlay {
	imageIds: string[];
	mainImageId?: string;
}

export interface DemoAccount {
	id: string;
	username: string;
	name: string;
	email: string;
	country: string;
	bios: Record<string, string>;
	intent: 'explore' | 'buy' | 'sell' | 'network' | null;
}

export interface DemoComment {
	id: string;
	text: string;
	commentableId: string;
	commentableType: string;
	parentId: string | null;
	createdAt: string;
	deleted?: boolean;
}

export interface DemoFolder {
	id: string;
	title: string;
	workIds: string[];
}

export interface DemoPost {
	id: string;
	title: string;
	body: ({ type: 'text'; text: string } | { type: 'image'; image_id: number })[];
	language: string;
	publishedAt: string | null;
	imageId?: string;
	deleted?: boolean;
}

export interface DemoMessage {
	id: string;
	body: string;
	mine: boolean;
	userId: string;
	createdAt: string;
	deleted?: boolean;
}

export interface DemoThread {
	id: string;
	participantId: string;
	title: string;
	messages: DemoMessage[];
}

export interface DemoNotification {
	id: string;
	type: string;
	readAt: string | null;
	createdAt: string;
	data: Record<string, unknown>;
}

export interface DemoState {
	photoId?: string;
	images: Record<string, DemoImage>;
	works: Record<string, DemoWorkOverlay>;
	created: DemoWorkDraft[];
	account?: DemoAccount;
	comments: DemoComment[];
	hiddenCommentIds: string[];
	votes: Record<string, 1 | -1>;
	follows: string[];
	folders: DemoFolder[];
	blocks: string[];
	posts: DemoPost[];
	threads: DemoThread[];
	notifications: DemoNotification[];
	preferences: { type: number; channel: number }[];
	feedback: unknown[];
	donations: { id: string; username: string; quantity: number; createdAt: string }[];
}

interface DemoContext {
	id: string;
	state: DemoState;
}

const demoContext = new AsyncLocalStorage<DemoContext | undefined>();

export function getDemoState(): DemoState | undefined {
	return demoContext.getStore()?.state;
}

export function runWithDemoSession<T>(context: DemoContext | undefined, fn: () => T): T {
	return demoContext.run(context, fn);
}

export function readSessionId(cookies: Cookies): string | undefined {
	const id = cookies.get(DEMO_COOKIE);
	if (!id || !/^[0-9a-f-]{36}$/i.test(id)) return undefined;
	return id;
}

export function setDemoCookie(cookies: Cookies, id: string, secure = false) {
	cookies.set(DEMO_COOKIE, id, {
		path: '/',
		httpOnly: true,
		sameSite: 'lax',
		secure,
		maxAge: DEMO_MAX_AGE
	});
}

export function clearDemoCookie(cookies: Cookies, secure = false) {
	cookies.delete(DEMO_COOKIE, { path: '/', secure });
}

export function emptyDemoState(): DemoState {
	return {
		images: {},
		works: {},
		created: [],
		comments: [],
		hiddenCommentIds: [],
		votes: {},
		follows: [],
		folders: [],
		blocks: [],
		posts: [],
		threads: [],
		notifications: [],
		preferences: [],
		feedback: [],
		donations: []
	};
}

export async function loadDemoState(sessionId: string): Promise<DemoState> {
	if (useBlob()) {
		const blob = await findStateBlob(sessionId);
		if (!blob) return emptyDemoState();
		const response = await fetch(blob.url);
		if (!response.ok) return emptyDemoState();
		return normalizeState(await response.json());
	}
	try {
		const raw = await readFile(localPath(sessionId, 'state.json'), 'utf8');
		return normalizeState(JSON.parse(raw));
	} catch {
		return emptyDemoState();
	}
}

export async function openDemoContext(sessionId: string | undefined) {
	if (!sessionId) return undefined;
	return { id: sessionId, state: await loadDemoState(sessionId) };
}

function requireContext() {
	const current = demoContext.getStore();
	if (!current?.id) error(401, 'Sign in to the demo first');
	return current;
}

export function parseTempId(value: unknown): string {
	const id = String(value ?? '')
		.replace(/^temp\//, '')
		.split('.')[0];
	if (!/^\d+$/.test(id)) error(400, 'Unknown upload');
	return id;
}

export async function saveDemoImage(file: File) {
	const current = requireContext();
	if (!ALLOWED_TYPES[file.type]) error(400, 'Use a JPEG, PNG, or WebP image');
	if (file.size > MAX_BYTES) error(400, 'Images must be 8 MB or smaller');

	const id = `${Date.now()}${Math.floor(Math.random() * 1000)}`;
	const bytes = Buffer.from(await file.arrayBuffer());
	let url = `/demo-files/${id}`;
	if (useBlob()) {
		url = await putBlob(`${prefix(current.id)}/${id}.${ALLOWED_TYPES[file.type]}`, bytes, file.type);
	} else {
		await mkdir(localDir(current.id), { recursive: true });
		await writeFile(localPath(current.id, id), bytes);
	}
	current.state.images[id] = { id, url, contentType: file.type };
	await persist(current);
	return { id, url };
}

export async function setDemoPhoto(tempId: string) {
	const current = requireContext();
	const id = parseTempId(tempId);
	if (!current.state.images[id]) error(400, 'Upload not found');
	current.state.photoId = id;
	await persist(current);
	return { ok: true };
}

export async function attachDemoImages(workId: string, tempIds: string[]) {
	const current = requireContext();
	const ids = tempIds.map((value) => parseTempId(value));
	for (const id of ids) {
		if (!current.state.images[id]) error(400, 'Upload not found');
	}
	const created = current.state.created.find((work) => work.id === workId);
	if (created) {
		created.imageIds.push(...ids);
		created.mainImageId ??= ids[0];
	} else {
		const overlay = current.state.works[workId] ?? { imageIds: [] };
		overlay.imageIds.push(...ids);
		overlay.mainImageId ??= ids.at(-1);
		current.state.works[workId] = overlay;
	}
	await persist(current);
	return { id: Number(workId) };
}

export async function createDemoWork(tempIds: string[]) {
	const current = requireContext();
	const ids = tempIds.map((value) => parseTempId(value));
	for (const id of ids) {
		if (!current.state.images[id]) error(400, 'Upload not found');
	}
	const id = `${Date.now()}`;
	current.state.created.unshift({
		id,
		title: 'New work',
		imageIds: ids,
		mainImageId: ids[0]
	});
	await persist(current);
	return { id: Number(id) };
}

export async function setDemoMainImage(workId: string, imageId: string) {
	const current = requireContext();
	const created = current.state.created.find((work) => work.id === workId);
	if (created) {
		if (!created.imageIds.includes(imageId)) error(404, 'Image not found');
		created.mainImageId = imageId;
	} else {
		const overlay = current.state.works[workId];
		if (!overlay?.imageIds.includes(imageId)) error(404, 'Image not found');
		overlay.mainImageId = imageId;
	}
	await persist(current);
	return { ok: true };
}

export async function deleteDemoImage(workId: string, imageId: string) {
	const current = requireContext();
	const created = current.state.created.find((work) => work.id === workId);
	const target = created ?? current.state.works[workId];
	if (!target) error(404, 'Image not found');
	target.imageIds = target.imageIds.filter((id) => id !== imageId);
	if (target.mainImageId === imageId) target.mainImageId = target.imageIds.at(-1);
	await persist(current);
	return { ok: true };
}

export async function readDemoImage(sessionId: string, imageId: string) {
	if (!/^\d+$/.test(imageId)) error(404, 'Not found');
	const state = await loadDemoState(sessionId);
	const image = state.images[imageId];
	if (!image) error(404, 'Not found');
	if (image.url.startsWith('http')) return { redirect: image.url, contentType: image.contentType };
	const bytes = await readFile(localPath(sessionId, imageId));
	return { bytes, contentType: image.contentType };
}

function normalizeState(value: Partial<DemoState> | null): DemoState {
	const empty = emptyDemoState();
	return {
		...empty,
		...value,
		images: value?.images ?? {},
		works: value?.works ?? {},
		created: value?.created ?? [],
		comments: value?.comments ?? [],
		hiddenCommentIds: value?.hiddenCommentIds ?? [],
		votes: value?.votes ?? {},
		follows: value?.follows ?? [],
		folders: value?.folders ?? [],
		blocks: value?.blocks ?? [],
		posts: value?.posts ?? [],
		threads: value?.threads ?? [],
		notifications: value?.notifications ?? [],
		preferences: value?.preferences ?? [],
		feedback: value?.feedback ?? [],
		donations: value?.donations ?? [],
		account: value?.account
			? {
					...value.account,
					bios: value.account.bios ?? {},
					intent: value.account.intent ?? 'explore'
				}
			: undefined
	};
}

export async function saveDemoState(sessionId: string, state: DemoState) {
	const body = JSON.stringify(state);
	if (useBlob()) {
		await putBlob(`${prefix(sessionId)}/state.json`, Buffer.from(body), 'application/json');
		return;
	}
	await mkdir(localDir(sessionId), { recursive: true });
	await writeFile(localPath(sessionId, 'state.json'), body);
}

export async function seedDemoAccount(
	sessionId: string,
	input: { id: string; username: string; name?: string; email: string; country?: string }
) {
	const state = await loadDemoState(sessionId);
	state.account = {
		id: input.id,
		username: input.username,
		name: input.name || input.username,
		email: input.email,
		country: input.country || state.account?.country || 'US',
		bios: state.account?.bios ?? {},
		intent: state.account?.intent ?? 'explore'
	};
	await saveDemoState(sessionId, state);
	return state.account;
}

export async function updateDemoState<T>(change: (state: DemoState) => T) {
	const current = requireContext();
	const result = change(current.state);
	await persist(current);
	return result;
}

function prefix(sessionId: string) {
	return `demo/${sessionId}`;
}

function localDir(sessionId: string) {
	return path.join(process.cwd(), '.demo-sessions', sessionId);
}

function localPath(sessionId: string, name: string) {
	return path.join(localDir(sessionId), name);
}

function useBlob() {
	return Boolean(process.env.BLOB_READ_WRITE_TOKEN);
}

async function persist(current: DemoContext) {
	await saveDemoState(current.id, current.state);
}

async function putBlob(pathname: string, body: Buffer, contentType: string) {
	const { put } = await import('@vercel/blob');
	const blob = await put(pathname, body, {
		access: 'public',
		token: process.env.BLOB_READ_WRITE_TOKEN,
		contentType,
		addRandomSuffix: pathname.endsWith('state.json')
	});
	return blob.url;
}

async function findStateBlob(sessionId: string) {
	const { list } = await import('@vercel/blob');
	const found = await list({
		prefix: `${prefix(sessionId)}/`,
		token: process.env.BLOB_READ_WRITE_TOKEN
	});
	return found.blobs
		.filter((blob) => blob.pathname.includes('state'))
		.sort((left, right) => new Date(right.uploadedAt).getTime() - new Date(left.uploadedAt).getTime())[0];
}
