<script lang="ts">
	import { localePath } from '$lib/translations';
	// export let href: string, active: boolean, clickHandler: () => void, title: string;
	export let href: string,
		active: boolean,
		clickHandler: () => void,
		title: string,
		dots = false;
	if (!href) {
		href = localePath(`/tag/${title}`);
	}
</script>

{#if title}
	{#if dots}
		<div class="w-1 h-1 md:h-2 md:w-2 rounded-full bg-amber-500 first-of-type:hidden" />
	{/if}
	<a
		{href}
		on:click={clickHandler}
		class="border border-gray-200  dark:border-gray-800 px-4 py-2 shadow-sm hover:border-amber-500 hover:shadow-md  dark:hover:border-amber-500 rounded-md
            {active ? 'bg-amber-600 dark:bg-amber-600 text-white' : 'dark:bg-gray-900'}">{title}</a
	>
{/if}
