<script lang="ts">
	import { localePath, t } from '$lib/translations';
	export let total, href;
</script>

<div
	class="flex items-center gap-3 justify-between py-3 sm:py-4 px-6 bg-gray-100 dark:bg-zinc-900 sticky top-0 z-10 border-b border-gray-200  font-semibold leading-6 dark:border-zinc-800"
>
	
	<slot />
	{#if total > 6}
	<a data-sveltekit-reload href={localePath(href)} class="  text-right cursor-pointer text-sky-700 dark:text-sky-600 hover:underline font-normal ">
		{$t('global.search.results.show_link')} &rarr;
	</a>
	{/if}
</div>
