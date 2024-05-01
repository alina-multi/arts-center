<script lang="ts">
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import GalleryFilters from '$lib/components/work/GalleryFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath } from '$lib/translations/';
	import { parse } from 'devalue';
	import { getContext } from 'svelte';
	import WorkModal from '$lib/components/work/WorkModal.svelte';

	const locale = getContext('locale');
	export let gallery;
	export let categories;
	export let params;
	let newBatch = [];
	let currentPage = params.page;
	let loading = false;
	let hasMore = gallery.length >= 20;
	$: gallery = [...gallery, ...newBatch];

	async function fetchData() {
		loading = true;
		let url = localePath($locale, `/api/tag/${params.tag}/${params.order}/${currentPage}`);
		const response = await fetch(url);
		const text = await response.text();
		const data = parse(text);
		newBatch = data.gallery;
		if (newBatch.length < 20) {
			hasMore = false;
		}
		loading = false;
	}
</script>

<div class=" mt-3 space-y-3 container mx-auto px-3">
	{#key $locale}
		<GalleryFilters {categories} {params} />
	{/key}
	<ul
		class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 lg:gap-3"
	>
		{#each gallery as work, index (work.id)}
			<WorkPreview {work} loading={index > 12 ? 'lazy' : 'eager'} />
		{/each}
	</ul>
	<InfiniteScroll
		{hasMore}
		{loading}
		on:loadMore={() => {
			currentPage++;
			fetchData();
		}}
	/>
</div>

<WorkModal {gallery} />
