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
	<div class="{media} flex-wrap items-center justify-start gap-6">
		{#each tags as { title } (title)}
			<TagButton
				href={localePath($locale, `/tag/${title}/popular`)}
				{title}
				styles={'px-3 py-1 border-zinc-800   text-zinc-800 dark:text-zinc-100  dark:border-zinc-700 rounded-2xl '}
			/>
		{/each}
	</div>
{/if}
