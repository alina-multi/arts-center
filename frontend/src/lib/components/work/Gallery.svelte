<script lang="ts">
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import GalleryFilters from '$lib/components/work/GalleryFilters.svelte';
	import InfiniteScroll from '$lib/components/atoms/InfiniteScroll.svelte';
	import { localePath } from '$lib/translations/';
	import { parse } from 'devalue';
	import { getContext } from 'svelte';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import WorkPage from '$lib/components/work/WorkPage.svelte';
	import { page } from '$app/stores';
	import globalLoading from '$lib/stores/loading';
	import { beforeNavigate, goto, preloadData, pushState } from '$app/navigation';
	import NavigationArrows from './NavigationArrows.svelte';

	const locale = getContext('locale');
	export let gallery;
	export let categories;
	export let params;
	let newBatch = [];
	let currentPage = params.page;
	let loading = false;
	let hasMore = gallery.length >= 20;
	$: gallery = [...gallery, ...newBatch];

	let initialHref = $page.url.href;

	$: currentWorkIndex = -1;

	$: if ($page?.state?.workModal) {
		currentWorkIndex = gallery.findIndex((work) => work.id === $page.state.workModal.work.id);
	}

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

	beforeNavigate(async (navigation: import('@sveltejs/kit').BeforeNavigate) => {
		if (navigation.to?.route.id === '/[[lang=lang]]/(with-nav)/(single-column)/work/[id=int]') {
			navigation.cancel();
			globalLoading.set(true);
			const preloaded = await preloadData(navigation.to?.url.href);
			globalLoading.set(false);
			if (preloaded.type === 'loaded') {
				pushState(navigation.to?.url.href, {
					workModal: {
						work: preloaded.data.work,
						comments: preloaded.data.comments
					}
				});

				// Fallback if for any reason preload fails
			} else {
				goto(preloaded.data.work);
			}
		}
	});

	function gotoGallery() {
		pushState(initialHref);
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

{#if $page?.state?.workModal}
	<ModalWindow
		class="container px-4 py-10 xs:px-6 xs:py-3 md:py-6 md:px-9 lg:px-0 lg:pb-12 xl:px-16 xs:my-12 xs:rounded-md  "
		on:close={gotoGallery}
		open={true}
		closeButtonAddStyle="max-xs:bg-white xs:text-white"
	>
		<div slot="otherEl" class="hidden xs:block">
			<NavigationArrows {currentWorkIndex} {gallery} />
		</div>

		<WorkPage {...$page.state.workModal} />
	</ModalWindow>
{/if}
