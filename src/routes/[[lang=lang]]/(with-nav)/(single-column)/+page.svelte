<script lang="ts">
	import type { PageData } from './$types';
	import Gallery from '$lib/components/work/Gallery.svelte';

	export let data: PageData;
	let gallery = data.gallery;
	let categories = data.categories;
	let params = data.params;
</script>

<Gallery {gallery} {categories}  {params}/>
