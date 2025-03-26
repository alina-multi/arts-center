<script lang="ts">
	import { onMount } from 'svelte';
	import PhotoSwipeLightbox from 'photoswipe/lightbox';
	import ImageLightBox from './ImageLightBox.svelte';
	import 'photoswipe/style.css';

	export let work;

	let galleryID = 'work-gallery';

	onMount(() => {
		let lightbox = new PhotoSwipeLightbox({
			gallery: '#' + galleryID,
			children: 'a',
			pswpModule: () => import('photoswipe')
		});
		lightbox.init();
	});
</script>

<div
	id={galleryID}
	class="pswp-gallery flex flex-col-reverse lg:flex-row lg:min-h-[calc(100vh-200px)] gap-4 lg:gap-9"
>
	{#if work.images.length > 0}
		<div
			class=" flex max-lg:justify-center lg:flex-col gap-3 flex-none overflow-x-scroll lg:overflow-y-scroll"
		>
			{#each work.images as image}
				<ImageLightBox
					alt={work.titles[0].alt}
					{image}
					class="flex-none"
					picture_class="w-16 h-16  object-cover  hover:opacity-80"
				/>
			{/each}
		</div>
	{/if}

	<ImageLightBox
		image={work.full}
		alt={work.titles[0].alt}
		picture_class=" md:max-h-screen lg:max-h-[calc(100vh-200px)] object-contain   "
	/>
</div>
