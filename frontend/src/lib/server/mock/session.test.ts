import { describe, expect, it, vi } from 'vitest';
import {
	DEMO_ACCOUNT_COOKIE,
	DEMO_COOKIE,
	clearDemoCookie,
	openDemoContext,
	readDemoAccountCookie,
	seedDemoAccount,
	setDemoAccountCookie,
	setDemoCookie
} from './session';
import type { Cookies } from '@sveltejs/kit';

function memoryCookies(initial: Record<string, string> = {}): Cookies {
	const store = new Map(Object.entries(initial));
	return {
		get: (name) => store.get(name),
		getAll: () => [...store.entries()].map(([name, value]) => ({ name, value })),
		set: (name, value) => {
			store.set(name, value);
		},
		delete: (name) => {
			store.delete(name);
		},
		serialize: () => ''
	} as Cookies;
}

describe('demo session cookies', () => {
	it('round-trips the account cookie used for serverless auth', () => {
		const cookies = memoryCookies();
		setDemoAccountCookie(cookies, {
			id: '123',
			username: 'maya',
			name: 'Maya',
			email: 'maya@example.com',
			country: 'US',
			bios: {},
			intent: 'explore'
		});
		expect(readDemoAccountCookie(cookies)?.email).toBe('maya@example.com');
		clearDemoCookie(cookies);
		expect(cookies.get(DEMO_COOKIE)).toBeUndefined();
		expect(cookies.get(DEMO_ACCOUNT_COOKIE)).toBeUndefined();
	});

	it('hydrates the demo account from cookie when storage is empty', async () => {
		vi.stubEnv('BLOB_READ_WRITE_TOKEN', '');
		const sessionId = '11111111-1111-4111-8111-111111111111';
		const cookies = memoryCookies();
		setDemoCookie(cookies, sessionId);
		setDemoAccountCookie(cookies, {
			id: '42',
			username: 'demo',
			name: 'demo',
			email: 'demo@arts.center',
			country: 'US',
			bios: {},
			intent: 'sell'
		});

		const context = await openDemoContext(sessionId, { cookies, secure: true });
		expect(context?.state.account?.email).toBe('demo@arts.center');
		expect(context?.state.account?.intent).toBe('sell');
		vi.unstubAllEnvs();
	});

	it('writes the account cookie during seedDemoAccount', async () => {
		vi.stubEnv('BLOB_READ_WRITE_TOKEN', '');
		vi.stubEnv('VERCEL', '1');
		const cookies = memoryCookies();
		const sessionId = '22222222-2222-4222-8222-222222222222';
		const account = await seedDemoAccount(
			sessionId,
			{ id: '99', username: 'nova', email: 'nova@arts.center' },
			{ cookies, secure: true }
		);
		expect(account.username).toBe('nova');
		expect(readDemoAccountCookie(cookies)?.email).toBe('nova@arts.center');
		vi.unstubAllEnvs();
	});
});
