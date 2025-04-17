<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { localePath } from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserGroup } from '@steeze-ui/heroicons';
	import { getContext, tick } from 'svelte';
	import SideNav from '../nav/side/SideNav.svelte';
	import { user as currentUser } from '$lib/stores/auth';

	const locale = getContext('locale');
	export let threads;

	let unreadBadgeVisible: Record<string, boolean> = {};

	let initialized = false;

	$: if (threads && !initialized) {
		for (const { id } of threads) {
			unreadBadgeVisible[id] = true;
		}
		initialized = true;
	}

	async function markThreadAsRead(threadId: string, unreadCount: number) {
		unreadBadgeVisible[threadId] = false;

		await tick();

		currentUser.update((user) => ({
			...user,
			unread_messages: Math.max((user.unread_messages || 0) - unreadCount, 0)
		}));
	}
</script>

<SideNav>
	{#each threads as { id, title, last_message, participants, exact, unread_messages } (id)}
		<SideNavLink href={localePath($locale, `/my/thread/${id}`)} {exact}>
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-static-element-interactions -->
			<div
				on:click={() => markThreadAsRead(id, unread_messages)}
				class="flex items-center justify-between w-full"
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

					<div class="overflow-hidden">
						<h3 class="font-semibold text-sm md:max-lg:text-xs">
							{title !== 'empty' ? title : participants[0]?.user.name}
						</h3>
						<p class="text-sm md:max-lg:text-xs text-gray-500 truncate">{last_message.message}</p>
					</div>
				</div>

				{#if unread_messages > 0 && unreadBadgeVisible[id]}
					<p
						class="min-w-6 h-6 px-2 flex items-center justify-center text-xs bg-blue-100 rounded-full"
					>
						{unread_messages}
					</p>
				{/if}
			</div>
		</SideNavLink>
	{/each}
</SideNav>
