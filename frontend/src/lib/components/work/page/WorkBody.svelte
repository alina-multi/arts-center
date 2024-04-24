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
</script>

<div class="pswp-gallery" id={galleryID}>
	<ImageLightBox image={work.full} alt={work.titles[0].alt} style={'w-full h-full'} original />
	{#if work.images.length > 0}
		<div class="pt-3 grid grid-cols-4 xl:grid-cols-5 gap-3">
			{#each work.images as image}
				<ImageLightBox {image} alt={work.titles[0].alt} />
			{/each}
		</div>
	{/if}
</div>
{#if description}
	<p class="whitespace-pre-line text-lg tracking-wider mt-3">{description ?? ''}</p>
{/if}
