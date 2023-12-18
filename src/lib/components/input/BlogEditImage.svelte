<script lang='ts'>
	import Picture from '$lib/components/atoms/Picture.svelte';

	export let image, focus;
</script>

{#if image}
	<Picture class='w-full' photo={image} />
{/if}