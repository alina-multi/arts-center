<script lang="ts">
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import GalleryFilters from '$lib/components/work/GalleryFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath } from '$lib/translations/';
	import * as devalue from 'devalue';
	export let gallery;
	export let categories;
	export let params;
	let newBatch = [];
	let page = params.page;
	let loading = false;
	let hasMore = true;
	// Just so svelte will redraw this :)
	params.lang;
	$: gallery = [...gallery, ...newBatch];
	async function fetchData() {
		loading = true;
		let url = localePath(`/api/tag/${params.tag}/${params.order}/${page}`);
		const response = await fetch(url);
		const text = await response.text();
		const data = devalue.parse(text);
		newBatch = data.gallery;
		if (newBatch.length < 20) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<div class=" mt-3 space-y-3">
	<GalleryFilters {categories} {params} />
	<ul
		class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 lg:gap-3"
	>
		{#each gallery as work}
			<WorkPreview {work} />
		{/each}
	</ul>
	<InfiniteScroll
		{hasMore}
		{loading}
		on:loadMore={() => {
			page++;
			fetchData();
		}}
	/>
</div>
