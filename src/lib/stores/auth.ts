import { writable } from 'svelte/store';
import type { Writable } from 'svelte/store';
import type { User } from '$lib/interfaces/User';
import { fetchData } from '$lib/helpers/fetchData';
import { parse } from 'devalue';
import { localePath } from '$lib/translations';

export const user: Writable<User | undefined> = writable();
export const isUserLoading: Writable<boolean> = writable(true);

export async function checkAuth() {
	fetchData('post', '/me').then(async (response) => {
		const text = await response.text();
		const userObj = parse(text);
		user.set(userObj?.id ? userObj : undefined);
		isUserLoading.set(false);
	});
}

export async function logout() {
	await fetchData('POST', localePath('/logout'));
	await checkAuth();
}
