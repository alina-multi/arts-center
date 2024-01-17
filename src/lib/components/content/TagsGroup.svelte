<script lang="ts">
	import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let tags = [],
		media: string;
</script>

{#if tags.length > 0}
	<div
		class="{media} flex-wrap items-center justify-start border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 sm:p-6 gap-6 md:py-6 p-3 rounded-sm"
	>
		<span class="font-semibold">{$t('global.filters.tags')}:</span>
		{#each tags as { title } (title)}
			<TagButton
				href={localePath($locale, `/tag/${title}/popular`)}
				{title}
				styles={'px-3 py-1 dark:border-zinc-700 '}
			/>
		{/each}
	</div>
{/if}
