<script lang="ts">
	import type { WorkPage } from '$lib/interfaces/Work';
	import TextBlock from '$lib/components/work/TextBlock.svelte';
	import ImageBlock from '$lib/components/work/ImageBlock.svelte';
	import GridBlock from '$lib/components/work/GridBlock.svelte';
	import { languageFilter } from '$lib/translations';

	BigInt.prototype.toJSON = function () {
		return this.toString();
	};
	export let work: WorkPage;
	$: blocks = languageFilter(work.blocks);
</script>

<h1 class="text-2xl font-bold">{work.titles[0].title}</h1>
{#each blocks as block}
	{#if block.type === 'text'}
		<TextBlock {block} />
	{/if}
	{#if block.type === 'image'}
		<ImageBlock {block} />
	{/if}
	{#if block.type === 'grid'}
		<GridBlock {block} />
	{/if}
{/each}
