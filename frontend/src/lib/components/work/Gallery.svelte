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
	$: newBatch = [];
	$: currentPage = params.page;
	let loading = false;
	$: hasMore = gallery.length >= 20;
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

<div class=" mt-6 space-y-6 lg:container mx-auto max-xl:px-3">
	{#key $locale}
		<GalleryFilters {categories} {params} />
	{/key}
	<ul class=" grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 sm:gap-6">
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
