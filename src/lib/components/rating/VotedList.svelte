<script lang="ts">
	import type { User } from '$/lib/interfaces/User';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import ModalWindow from '$lib/components/ModalWindow.svelte';

	export let votes: User[] = [],
		isLiked = false,
		currentUser: User = null;
	// For now let's just show the first 3 votes
	// Later, this can be friends first like on FB
	let votesPreview = votes?.slice(0, 3);
	let showLikedByModal = false;
</script>

<div class="flex items-center gap-1 dark:text-zinc-300 max-[400px]:text-xs text-sm lg:text-base">
	{#if votes.length > 0}
		<button on:click={() => (showLikedByModal = true)} class="hover:underline cursor-pointer">
			<span class="mr-1">Liked by</span>
		</button>

		<div class="flex -space-x-3 cursor-pointer">
			{#each votesPreview as user}
				<Avatar {user} size={'w-6 h-6 md:w-7 md:h-7'} />
			{/each}
			{#if isLiked}
				<Avatar user={currentUser} size={'w-6 h-6 md:w-7 md:h-7'} />
			{/if}
		</div>
	{/if}

	{#if votes.length > 3}
		<div>
			<span class="text-zinc-500 dark:text-zinc-400">and</span>
			<button on:click={() => (showLikedByModal = true)} class="hover:underline cursor-pointer">
				others
			</button>
		</div>
	{/if}
</div>

<ModalWindow bind:open={showLikedByModal}>
	<h2 slot="header" class="flex justify-between font-semibold">Liked by</h2>

	<ul
		class="flex flex-col gap-3 max-h-96 overflow-y-scroll px-3 border-y py-3 dark:border-zinc-800"
	>
		{#each votes as user}
			<li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
				<Avatar {user} withName size={'w-8 h-8'} nameStyles={'text-sm font-semibold '} />
			</li>
		{/each}
	</ul>
	<div slot="footer" class="text-right">
		<button
			class="px-3 py-1 rounded-full text-sm text-zinc-500 hover:ring-1 hover:ring-zinc-300 dark:ring-zinc-700"
			on:click={() => (showLikedByModal = false)}
		>
			Close
		</button>
	</div>
</ModalWindow>
