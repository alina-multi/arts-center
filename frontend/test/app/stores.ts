import { writable } from 'svelte/store';

// Fake version of $app/stores
export const page = writable({
	data: {
		currentUser: {}
	}
});
