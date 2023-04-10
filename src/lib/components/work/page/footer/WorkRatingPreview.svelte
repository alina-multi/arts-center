<script lang="ts">
	import type { Work } from '$lib/interfaces/Work';
	import Avatar from '$lib/components/atoms/Avatar.svelte';
	import ModalWindow from '$lib/components/ModalWindow.svelte';

	export let work: Work;
	let showLikedByModal = false;
	// For now let's just show the first 3 votes
	// Later, this can be friends first like on FB
	const votesPreview = work?.votes?.slice(0, 3);
</script>

<ModalWindow bind:open={showLikedByModal}>
	<h2 slot="header" class="flex justify-between text-lg font-semibold text-gray-800 ">Liked by</h2>

	<ul class="flex flex-col gap-3  text-sm pt-6 ">
		{#each work.votes as user}
			<li class="flex items-center gap-3 text-base text-gray-700">
				<Avatar {user} withName />
			</li>
		{/each}
	</ul>
</ModalWindow>

<div class="flex items-end gap-1 dark:text-gray-300 max-[400px]:text-xs ">
	<button on:click={() => (showLikedByModal = true)} class="hover:underline cursor-pointer ">
		<span class="">Liked by</span>
		{work.rating}
	</button>

	{#if work.votes.length > 0}
		<div class="flex -space-x-3 cursor-pointer">
			{#each votesPreview as user}
				<Avatar {user} />
			{/each}
		</div>
	{:else}
		<span class="text-gray-500 dark:text-gray-400">0</span>
	{/if}

	{#if work.votes.length > 3}
		<div>
			<span class="text-gray-500 dark:text-gray-400">and</span>
			<button on:click={() => (showLikedByModal = true)} class="hover:underline cursor-pointer ">
				others
			</button>
		</div>
	{/if}
</div>
