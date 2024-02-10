<script lang="ts">
	import { notifications, user } from '$lib/stores/auth';
	import toast from 'svelte-french-toast';
	import Notification from '$lib/components/notification/Notification.svelte';
	import type { UserMe } from '$lib/interfaces/User';

	notifications.subscribe((rows) => {
		if (rows.length) {
			for (const notification of rows) {
				if (notification.viewed) continue;
				notification.viewed = true;
				toast(Notification, {
					duration: 2500,
					position: 'top-right',

					notification
				});
				user.update((u: UserMe) => ({
					...u,
					unread: u.unread + 1
				}));
			}
		}
	});
</script>
