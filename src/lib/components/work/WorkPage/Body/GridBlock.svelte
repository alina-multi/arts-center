<script lang="ts">
	import { onMount } from 'svelte';
	import PhotoSwipeLightbox from 'photoswipe/lightbox';
	import 'photoswipe/style.css';
	let galleryID = 'work-gallery';
	export let block: any;

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
	<div class="grid grid-cols-2 sm:grid-cols-3 gap-3 lg:flex">
		{#each block.images as image}
			<a
				href={image.src}
				data-pswp-width="1000"
				data-pswp-height="800"
				target="_blank"
				rel="noreferrer"
			>
				<img
					src={image.src}
					alt=""
					class="aspect-[4/3] object-cover object-center opacity-90 hover:opacity-100 cursor-pointer "
				/>
			</a>
		{/each}
	</div>
</div>
