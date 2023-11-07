<script lang='ts'>
	import { notifications, user } from '$lib/stores/auth';
	import toast from 'svelte-french-toast';
	import Notification from '$lib/components/notification/Notification.svelte';
	import type { UserMe } from '$lib/interfaces/User';

	notifications.subscribe((rows) => {
		if (rows.length) {
			for (const notification of rows) {
				toast(Notification, {
					duration: 50000,
					//@ts-ignore
					notification
				});
			}
			user.update((u: UserMe) => ({
				...u,
				unread: u.unread + rows.length
			}));
			notifications.set([]);
		}
	});
</script>
