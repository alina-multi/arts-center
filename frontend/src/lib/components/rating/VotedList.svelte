<script lang="ts">
	import type { User } from '$/lib/interfaces/User';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');

	export let votes: User[] = [],
		isLiked = false,
		currentUser: User = null;
	// For now let's just show the first 3 votes
	// Later, this can be friends first like on FB
	let votesPreview = votes?.slice(0, 3);
	let showLikedByModal = false;
</script>

<div class="flex items-center gap-1 dark:text-zinc-300">


	{#if votes.length > 3}
	<button on:click={() => (showLikedByModal = true)} class="hover:underline cursor-pointe mr-1">
		{$t('global.voting.liked_by')}
	</button>

	<div class="flex -space-x-3 cursor-pointer">
		{#each votesPreview as user (user.id)}
			<AvatarLink {user} size={'w-8 h-8'} />
		{/each}
	
	</div>
		<div class=" hidden min-[400px]:block">
			<span class="text-zinc-500 dark:text-zinc-400 max-sm:hidden">{$t('global.voting.and')}</span>
			<button
				on:click={() => (showLikedByModal = true)}
				class="hover:underline cursor-pointer max-sm:hidden"
			>
				{$t('global.voting.others')}
			</button>
		</div>
	{/if}
</div>

<ModalWindow bind:open={showLikedByModal} class="xl:w-1/3 rounded-sm my-24  sm:w-3/4 md:w-2/3">
	<h2 slot="header" class="flex justify-between font-semibold pb-3 pt-6 px-6">
		{$t('global.voting.liked_by')}
	</h2>

	<ul
		class=" flex flex-col gap-3 lg:max-h-96 h-2/3 overflow-y-scroll px-6 border-y py-3 dark:border-zinc-800"
	>
		{#each votes as user }
			<li class="flex items-center gap-3">
				<AvatarLink
					{user}
					withName
					size={'w-9 h-9'}
					nameStyles={'text-sm font-semibold text-black dark:text-white'}
				/>
			</li>
		{/each}
	</ul>
	<div slot="footer" class="text-right px-6 pb-5">
		<button
			class="py-1 px-3 rounded-sm text-zinc-500 hover:ring-1 hover:ring-zinc-300 dark:ring-zinc-700"
			on:click={() => (showLikedByModal = false)}
		>
			{$t('global.buttons.close')}
		</button>
	</div>
</ModalWindow>
