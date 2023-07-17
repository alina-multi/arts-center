<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	export let image, alt;
    let style = 'aspect-[4/3] flex object-cover';
    console.log(image);
</script>

{#if image?.original}
	<div class=" rounded-sm bg-gray-100 dark:bg-zinc-900 overflow-hidden aspect-[4/3]">
		<a
			href={image?.original.src}
			data-pswp-width={image?.original.width}
			data-pswp-height={image?.original.height}
			target="_blank"
			rel="noreferrer"
			class="cursor-zoom-in"
		>
			<Picture photo={image} {alt} {style} />
		</a>
	</div>
{/if}
