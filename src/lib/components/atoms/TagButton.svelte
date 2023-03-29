<script lang="ts">
	import { localePath, languageFind } from '../../translations';

	export let tag;
	const { title } = languageFind(tag.titles) || {};
	export let href = localePath(`/tag/${title}`);
</script>

{#if title}
	<div class="w-1 h-1 md:h-2 md:w-2 rounded-full bg-amber-500 first-of-type:hidden" />
	<a
		{href}
		class="bg-white px-3 py-1 rounded-md hover:border border hover:shadow-md dark:bg-gray-800 dark:border-transparent dark:hover:border-gray-600"
	>
		{title}
	</a>
{/if}
