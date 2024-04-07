<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	export let image,
		alt: string,
		original: boolean = false,
		style = 'aspect-[4/3] flex object-cover';
</script>

<div class="rounded-sm bg-zinc-900 dark:bg-zinc-900 overflow-hidden {original ? '' : 'aspect-[4/3]'}">
	<a
		href={image?.original?.src}
		data-pswp-width={image?.original?.width}
		data-pswp-height={image?.original?.height}
		target="_blank"
		rel="noreferrer"
		class="cursor-zoom-in"
	>
		<Picture photo={image} {alt} class={style} />
	</a>
</div>
