<script lang="ts">
	import TextBlock from '$lib/components/work/page/body/TextBlock.svelte';
	import ImageBlock from '$lib/components/work/page/body/ImageBlock.svelte';
	import GridBlock from '$lib/components/work/page/body/GridBlock.svelte';
	export let work;
</script>

<div class="space-y-6">
	{#each work.blocks as block}
		{#if block.type === 'image'}
			<ImageBlock {block} />
		{/if}
		{#if block.type === 'text'}
			<TextBlock {block} />
		{/if}
		{#if block.type === 'grid'}
			<GridBlock {block} />
		{/if}
	{/each}
</div>
