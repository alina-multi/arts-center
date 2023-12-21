import type { Writable } from 'svelte/store';
import { writable } from 'svelte/store';
import type { UserMe } from '$lib/interfaces/User';
import { fetchData } from '$lib/helpers/fetchData';
import { parse } from 'devalue';
import { localePath } from '$lib/translations';
import * as Ably from 'ably';
import Echo from '@ably/laravel-echo';
import type { Notification } from '$lib/interfaces/Notification';

export const user: Writable<UserMe> = writable();
export const isUserLoading: Writable<boolean> = writable(true);

export const notifications: Writable<Notification[]> = writable([]);

export async function checkAuth() {
	fetchData('post', '/me').then(async (response) => {
		const text = await response.text();
		const userObj = parse(text);
		user.set(userObj?.id ? userObj : undefined);
		isUserLoading.set(false);
	});
}

export async function logout(lang) {
	await fetchData('POST', localePath(lang, '/logout'));
	await checkAuth();
}

// Since we make auth client-side, this should be safe
user.subscribe((user) => {
	if (user?.id && !window.Echo) {
		window.Ably = Ably;
		window.Echo = new Echo({
			broadcaster: 'ably',
			authEndpoint: '/api/broadcasting'
		});
		window.Echo.private(`user.${user.id}`).notification((notification) => {
			notifications.update((current) => [...current, notification]);
		});
	}
});
