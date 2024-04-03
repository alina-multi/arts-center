<script lang="ts">
	export let alt: string;
	export let photo;
	let clazz: string;
	export { clazz as class };

</script>

<picture class={clazz}>
	{#if photo?.sources}
		{#each photo.sources as { srcset, type } (type)}
			<source {srcset} {type} />
		{/each}
	{/if}
	<img src={photo?.src} {alt} class={clazz} width={photo.original.width} height={photo.original.height} />
</picture>
