<script lang="ts">
import TagButton from '$lib/components/atoms/buttons/TagButton.svelte';
    export let tags = [], media: string;
</script>

{#if tags.length > 0}

			<div
				class="{media} flex-wrap items-center justify-start border border-gray-200 dark:border-zinc-800 dark:bg-zinc-900 sm:p-3 gap-3 md:py-[9px] p-3 rounded-sm  bg-gray-100"
			>
	
				<span>Tags:</span>
				{#each tags as { title }}
					<TagButton href={`/tag/${title}/popular`} title={title} styles={'px-3 py-0.5 dark:border-zinc-700 '}  />
				{/each}
			
				
			</div>
		{/if}