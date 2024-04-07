<script lang="ts">
	import { getContext, onMount } from 'svelte';
	import { languageFind } from '$lib/translations';
	import PhotoSwipeLightbox from 'photoswipe/lightbox';
	import ImageLightBox from './ImageLightBox.svelte';
	import 'photoswipe/style.css';

	const locale = getContext('locale');

	export let work;
	let description = languageFind(work.titles, $locale)?.description;

	let galleryID = 'work-gallery';

	onMount(() => {
		let lightbox = new PhotoSwipeLightbox({
			gallery: '#' + galleryID,
			children: 'a',
			pswpModule: () => import('photoswipe')
		});
		lightbox.init();
	});

	let calculateGrid = Math.round(work.images.length / 2);
</script>

<div class="pswp-gallery {work.images.length > 1 ? 'space-y-2 sm:space-y-3' : ''}" id={galleryID}>
	<ImageLightBox image={work.full} alt={work.titles[0].alt} style={'w-full h-full'} original />
	<div
		class="{work.images.length >= 6
			? 'grid grid-cols-3 sm:flex '
			: `grid grid-cols-${calculateGrid}`}  gap-2 sm:gap-3"
	>
		{#each work.images as image}
			<ImageLightBox {image} alt={work.titles[0].alt} />
		{/each}
	</div>
</div>
{#if description}
	<p class="whitespace-pre-line text-lg font-serif mt-3">{description ?? ''}</p>
{/if}
