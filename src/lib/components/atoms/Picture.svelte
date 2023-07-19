<script lang="ts">
	export let alt: string;
	export let photo;
	export let style: string;
</script>

<picture class={style}>
	{#each photo.sources as { srcset, type }}
		<source {srcset} {type} />
	{/each}
	<img src={photo.src} {alt} class={style} />
</picture>
