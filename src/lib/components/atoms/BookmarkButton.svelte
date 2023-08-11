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
	class="group text-sm  dark:text-zinc-400   text-gray-500 dark:border-zinc-700"
>
	{#if isBookmarked}
		<span class="sr-only"> Unbookmark </span>

		<Icon src={BookmarkSlash} class="h-7 w-7 text-gray-400 dark:text-zinc-600" aria-hidden="true" />
	{:else}
		<span class="sr-only">Bookmark</span>
		<Icon
			src={Bookmark}
			class="h-7 w-7  group-hover:fill-teal-500 group-hover:stroke-teal-500"
			aria-hidden="true"
		/>
	{/if}
</button>
