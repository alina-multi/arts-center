<script lang="ts">
	import { t, localePath } from '$lib/translations';
	export let query: string = '',
		options: { title: string; total: number; path: string }[] = [];
</script>

<section aria-labelledby="filter-heading">
	<h2 id="filter-heading" class="sr-only">Filters</h2>
	<div class=" flex flex-col divide-y dark:divide-zinc-800">
		<div
			class="pt-3 px-6 pb-3 w-full bg-gray-100 dark:bg-zinc-900 text-black dark:text-zinc-400"
		>
			{$t('global.search.results.found') + ' ' + $t('global.search.results.for')}
			<span class="underline">{query}</span>
		</div>

		{#each options as { title, total, path } (title)}
			<a
				href={localePath(`/search/${path}/${query}`)}
				class=" py-3 px-6 w-full text-black dark:text-white flex items-center justify-between gap-3 hover:text-black"
			>
				<div class="flex gap-3 items-center">
					<span class="text-sm text-black dark:text-white"
						>{$t(`global.search.results.${title}`).toUpperCase()}</span
					>
					<span>-</span>
					<span
						class=" underline hover:text-gray-700 text-gray-500 dark:text-zinc-400 dark:hover:text-zinc-200"
					>
						{total}
						{$t('global.search.results.results')}
					</span>
				</div>
			</a>
		{/each}
	</div>
</section>
