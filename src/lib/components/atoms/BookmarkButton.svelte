<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bookmark, BookmarkSlash } from '@steeze-ui/heroicons';

	let isBookmarked = false;

	function onBookmark() {
		isBookmarked = !isBookmarked;
	}
</script>

<button
	type="button"
	on:click={onBookmark}
	class="group flex items-center text-sm gap-1 border dark:text-white rounded-full dark:bg-zinc-800 px-3 py-1 shadow-md text-gray-700 dark:border-zinc-700 "
>
	{#if isBookmarked}
		<span class="sr-only"> Unbookmark </span>

		<Icon src={BookmarkSlash} class="h-6 w-6 text-gray-400 dark:text-zinc-600" aria-hidden="true" />
	{:else}
		<span class="sr-only">Bookmark</span>
		<Icon src={Bookmark} class="h-6 w-6  group-hover:fill-teal-500 group-hover:stroke-teal-500" aria-hidden="true" />
	{/if}
</button>
