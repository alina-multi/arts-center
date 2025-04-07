<script lang="ts">
	import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';

	const locale = getContext('locale');
	export let tags = [];
</script>

{#if tags.length > 0}
	<div class="flex flex-wrap items-center justify-start gap-3">
		{#each tags as { title } (title)}
			<TagButton
				href={localePath($locale, `/tag/${title}/popular`)}
				{title}
				styles={'px-4 py-1 bg-zinc-100  text-zinc-600 dark:text-zinc-100  border-0 rounded-full  '}
			/>
		{/each}
	</div>
{/if}
