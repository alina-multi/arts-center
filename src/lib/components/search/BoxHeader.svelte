<script lang="ts">
	import { localePath } from '$lib/translations';
	export let total, href;
</script>

<div
	class="flex items-center justify-between py-3 sm:py-4 px-6 bg-gray-100 dark:bg-zinc-900 sticky top-0 z-10 border-b border-gray-200 text-sm font-semibold leading-6 dark:border-zinc-800"
>
	
	<slot />
	{#if total > 20}
		<a data-sveltekit-reload href={localePath(href)} class="text-blue-700 hover:underline font-normal">
			show full results &rarr;
		</a>
	{/if}
</div>
