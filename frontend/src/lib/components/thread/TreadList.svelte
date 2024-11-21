<script lang="ts">
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import { localePath } from '$lib/translations';
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserGroup } from '@steeze-ui/heroicons';
	import { getContext } from 'svelte';
	import SideNav from '../nav/side/SideNav.svelte';

	const locale = getContext('locale');

	export let threads;
</script>

<SideNav>
	{#each threads as { id, title, last_message, participants, exact } (id)}
		<SideNavLink href={localePath($locale, `/my/thread/${id}`)} {exact}>
			<!--temporary fix, need improving -->

			{#if title != 'empty' && participants.length > 1}
				<Icon
					theme="solid"
					src={UserGroup}
					class=" h-14 w-14 shrink-0 bg-gray-50 dark:bg-zinc-800 rounded-full fill-zinc-300 dark:fill-zinc-400  p-2 border border-zinc-100 dark:border-zinc-700 shadow-sm"
				/>
			{:else if title != 'empty' && participants.length === 1}
				<Avatar user={participants[0]?.user} size="h-12 w-12" />
			{:else}
				<Avatar user={participants[0]?.user} size="h-12 w-12" />
			{/if}

			<div class="overflow-hidden">
				<h3 class="font-semibold text-sm">
					{title != 'empty' ? title : participants[0]?.user.name}
				</h3>
				<p class="text-sm text-gray-500 truncate">{last_message.message}</p>
			</div>
		</SideNavLink>
	{/each}
</SideNav>
