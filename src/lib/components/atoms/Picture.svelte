<script lang="ts">
	export let alt: string;
	export let photo;
	export let style: string;
</script>

<picture class={style}>
	{#if photo?.sources}
		{#each photo.sources as { srcset, type }}
			<source {srcset} {type} />
		{/each}
	{/if}
	<img src={photo?.src} {alt} class={style} />
</picture>
