export const ACCOUNTS_KEY = 'arts-demo-accounts';
export const CURRENT_KEY = 'arts-demo-current';
export const RESET_KEY = 'arts-demo-reset';

export interface DemoAccountRecord {
	sessionId: string;
	id: string;
	username: string;
	name: string;
	email: string;
	password: string;
	country: string;
}

function readList(): DemoAccountRecord[] {
	if (typeof localStorage === 'undefined') return [];
	try {
		const parsed = JSON.parse(localStorage.getItem(ACCOUNTS_KEY) || '[]');
		return Array.isArray(parsed) ? parsed : [];
	} catch {
		return [];
	}
}

function writeList(accounts: DemoAccountRecord[]) {
	localStorage.setItem(ACCOUNTS_KEY, JSON.stringify(accounts));
}

export function listAccounts() {
	return readList();
}

export function rememberCurrent(sessionId: string) {
	localStorage.setItem(CURRENT_KEY, sessionId);
}

export function registerAccount(input: {
	username: string;
	email: string;
	password: string;
	passwordConfirmation: string;
}) {
	const username = input.username.trim();
	const email = input.email.trim().toLowerCase();
	const errors: Record<string, string> = {};
	if (!username) errors.username = 'Username is required';
	if (!/^[a-z0-9][a-z0-9-]{1,30}$/i.test(username)) {
		errors.username = errors.username || 'Use letters, numbers, and hyphens';
	}
	if (!email || !email.includes('@')) errors.email = 'Email is required';
	if (!input.password || input.password.length < 8) {
		errors.password = 'Password must be at least 8 characters';
	}
	if (input.password !== input.passwordConfirmation) {
		errors.password_confirmation = 'Password confirmation does not match';
	}
	const accounts = readList();
	if (accounts.some((account) => account.email === email)) {
		errors.email = 'This email is already registered';
	}
	if (accounts.some((account) => account.username.toLowerCase() === username.toLowerCase())) {
		errors.username = 'This username is already taken';
	}
	if (Object.keys(errors).length) return { errors, username, email };
	const account: DemoAccountRecord = {
		sessionId: crypto.randomUUID(),
		id: `${Date.now()}`,
		username,
		name: username,
		email,
		password: input.password,
		country: 'US'
	};
	writeList([account, ...accounts]);
	return { account };
}

export function matchLogin(email: string, password: string) {
	const normalized = email.trim().toLowerCase();
	return readList().find((account) => account.email === normalized && account.password === password);
}

export function updateStoredAccount(patch: Partial<DemoAccountRecord>) {
	const sessionId = localStorage.getItem(CURRENT_KEY);
	const email = patch.email?.trim().toLowerCase();
	let matched = false;
	const accounts = readList().map((account) => {
		const sameSession = Boolean(sessionId) && account.sessionId === sessionId;
		const sameEmail = !sessionId && Boolean(email) && account.email === email;
		if (!sameSession && !sameEmail) return account;
		matched = true;
		return {
			...account,
			...patch,
			email: (patch.email || account.email).trim().toLowerCase(),
			password: patch.password || account.password
		};
	});
	if (!matched) return;
	writeList(accounts);
}

export function ensureGoogleAccount() {
	const email = 'google.demo@arts.center';
	const existing = readList().find((account) => account.email === email);
	if (existing) return existing;
	const account: DemoAccountRecord = {
		sessionId: crypto.randomUUID(),
		id: `${Date.now()}`,
		username: 'google-demo',
		name: 'Google Demo',
		email,
		password: crypto.randomUUID(),
		country: 'US'
	};
	writeList([account, ...readList()]);
	return account;
}

export function startPasswordReset(email: string) {
	const account = readList().find((item) => item.email === email.trim().toLowerCase());
	if (!account) return null;
	const token = crypto.randomUUID();
	localStorage.setItem(RESET_KEY, JSON.stringify({ email: account.email, token }));
	return { email: account.email, token };
}

export function completePasswordReset(token: string, email: string, password: string) {
	const saved = JSON.parse(localStorage.getItem(RESET_KEY) || 'null');
	if (!saved || saved.token !== token || saved.email !== email.trim().toLowerCase()) {
		return { errors: { password: 'This reset link is not valid in this browser' } };
	}
	if (!password || password.length < 8) {
		return { errors: { password: 'Password must be at least 8 characters' } };
	}
	const accounts = readList().map((account) =>
		account.email === saved.email ? { ...account, password } : account
	);
	writeList(accounts);
	localStorage.removeItem(RESET_KEY);
	return { ok: true };
}
