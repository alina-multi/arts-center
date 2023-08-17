<script lang="ts">
	import { onMount } from 'svelte';
	import {languageFind} from '$lib/translations';
	import PhotoSwipeLightbox from 'photoswipe/lightbox';
	import ImageLightBox from './ImageLightBox.svelte';
	import 'photoswipe/style.css';
	export let work;
	let description = languageFind(work.titles)?.description;

	let galleryID = 'work-gallery';
	

	onMount(() => {
		let lightbox = new PhotoSwipeLightbox({
			gallery: '#' + galleryID,
			children: 'a',
			pswpModule: () => import('photoswipe')
		});
		lightbox.init();
	});

	let grid = work.images;
	let isOdd = grid.length % 2 !== 0;
	grid = isOdd ? grid.slice(0, grid.length - 1) : grid;
	let lastChild = isOdd ? grid[grid.length - 1] : null;
</script>

<div class="pswp-gallery {grid.length > 1 ? 'space-y-2 sm:space-y-3' : ''}" id={galleryID}>
	<ImageLightBox image={work.full} alt={work.titles[0].alt} style={'w-full h-full'} original />
	<div class="grid grid-cols-2 md:grid-cols-3 gap-2 sm:gap-3">
		{#each grid as image}
			<ImageLightBox {image} alt={'??? doesnt exist'} />
		{/each}
	</div>
	{#if lastChild}
		<ImageLightBox image={lastChild} alt={'??? doesnt exist'} />
	{/if}
</div>
<p class="whitespace-pre-line">{description??''}</p>
