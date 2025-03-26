<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	export let image, picture_class, alt;
	let clazz: string;
	export { clazz as class };
</script>

<a
	href={image?.original?.src}
	data-pswp-width={image?.original?.width}
	data-pswp-height={image?.original?.height}
	target="_blank"
	rel="noreferrer"
	class="cursor-zoom-in {clazz}  "
>
	<Picture photo={image} {alt} class={picture_class} />
</a>
