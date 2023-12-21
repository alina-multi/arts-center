<script lang="ts">
	import { onMount, onDestroy, createEventDispatcher } from 'svelte';
	import Loader from '$lib/components/atoms/Loader.svelte';
	export let hasMore: boolean = true;
	export let loading: boolean = false;
	const dispatch = createEventDispatcher();
	let el, observer;
	async function loadMore(entries) {
		// intersectionRatio is 1 when moving down. It also fires event when moving up we don't need it
		if (entries[0].intersectionRatio == 1 && !loading && hasMore) {
			dispatch('loadMore');
		}
	}
	onMount(() => {
		observer = new IntersectionObserver(loadMore, { threshold: 1, root: null, rootMargin: '10%' });
		// So it will not load immediately page 2 because while things are loading
		// the InfiniteScroll component can momentarily be in viewport
		setTimeout(() => {
			observer.observe(el);
		}, 300);
	});
	// todo: figure out do we need to clean up this ourselves or does it get cleaned up automatically
	onDestroy(() => {
		observer?.disconnect();
	});
</script>

<div class="flex justify-center w-full" bind:this={el}>
	{#if loading}
		<div class="w-20 h-20 flex justify-center m-20">
			<Loader />
		</div>
	{/if}
</div>
