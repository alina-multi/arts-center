<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserGroup } from '@steeze-ui/heroicons';
	import { user as currentUser, newMessage, threadsStore } from '$lib/stores/auth';
	import {  invalidateAll } from '$app/navigation';


	export let id, title, last_message, participants, unread_messages;

	async function markThreadAsRead(threadId: string, unreadCount: number) {
		currentUser.update((user) => ({
			...user,
			unread_messages: Math.max((user.unread_messages || 0) - unreadCount, 0)
		}));

		threadsStore.update((threads) => {
			for (const thr of threads) {
				if (thr.id === threadId) {
					thr.unread_messages = 0;
				}
			}
			return threads;
		});
		
		unread_messages = 0;
        newMessage.set(null)
		invalidateAll()
	}
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<div
	on:click={() => markThreadAsRead(id, unread_messages)}
	class="flex items-center justify-between relative w-full"
>
	<div class="flex items-center gap-x-3 py-2">
		{#if title !== 'empty' && participants.length > 1}
			<Icon
				theme="solid"
				src={UserGroup}
				class="h-14 w-14 shrink-0 bg-gray-50 dark:bg-zinc-800 rounded-full fill-zinc-300 dark:fill-zinc-400 p-2 border border-zinc-100 dark:border-zinc-700 shadow-sm"
			/>
		{:else}
			<Avatar user={participants[0]?.user} size="h-12 w-12 md:max-lg:h-8 md:max-lg:w-8" />
		{/if}

		<div class="">
			<h3 class="font-semibold text-sm md:max-lg:text-xs">
				{title !== 'empty' ? title : participants[0]?.user.name}
			</h3>
			<p
				class="text-sm md:max-lg:text-xs text-gray-500 truncate overflow-hidden whitespace-nowrap text-ellipsis md:max-w-[140px] lg:max-w-[220px] xl:max-w-[300px]"
			>
				{last_message.message}
			</p>
		</div>
	</div>

	{#if unread_messages > 0}
		<p
			class="absolute -right-3 min-w-5 h-5 p-1 flex items-center justify-center text-xs bg-red-500 text-white rounded-full"
		>
			{unread_messages}
		</p>
	{/if}
</div>
