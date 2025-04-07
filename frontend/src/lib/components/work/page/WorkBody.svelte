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
	class="pswp-gallery flex flex-col-reverse xl:flex-row xl:max-h-[calc(100vh-200px)] gap-4 lg:gap-9"
>
	{#if work.images.length > 0}
		<div
			class=" flex max-xl:justify-center h-full xl:flex-col gap-3 flex-none overflow-x-scroll max-xl:scrollbar-hide xl:overflow-y-scroll"
		>
			{#each work.images as image}
				<ImageLightBox
					alt={work.titles[0].alt}
					{image}
					class="flex-none"
					picture_class="w-20 h-20 max-xl:w-32 max-xl:h-32  object-cover  hover:opacity-80"
				/>
			{/each}
		</div>
	{/if}

	<ImageLightBox
		image={work.full}
		alt={work.titles[0].alt}
		picture_class="  h-full w-full object-contain object-top "
	/>
</div>
