<script lang="ts">
	import { notifications, user, newMessages, threadsStore, newMessage } from '$lib/stores/auth';
	import toast from 'svelte-french-toast';
	import Notification from '$lib/components/notification/Notification.svelte';
	import type { UserMe } from '$lib/interfaces/User';

	function showNotification(notification: any) {
		toast(Notification, {
			duration: 2500,
			position: 'top-right',
			notification
		});
	}

	function handleThreadsStore(newMessage) {
		threadsStore.update((threads) => {
			for (const thr of threads) {
				if (thr.id === newMessage.thread_id) {
					thr.last_message = { message: newMessage.message };
					(thr.unread_messages = thr.unread_messages + 1), (thr.type = newMessage.type);
				}
			}
			return threads;
		});
	}

	newMessages.subscribe((rows) => {
		if (rows.length) {
			for (const message of rows) {
				if (message.viewed) continue;
				message.viewed = true;
				newMessage.set(message);
				handleThreadsStore(message);
				showNotification(message);

				user.update((u: UserMe) => ({
					...u,
					unread_messages: u.unread_messages + 1
				}));
			}
		}
	});

	notifications.subscribe((rows) => {
		if (rows.length) {
			for (const notification of rows) {
				if (notification.viewed) continue;
				notification.viewed = true;
				showNotification(notification);
				user.update((u: UserMe) => ({
					...u,
					unread: u.unread + 1
				}));
			}
		}
	});
</script>
