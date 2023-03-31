<script lang="ts">
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import GalleryFilters from '$lib/components/work/GalleryFilters.svelte';
	export let gallery;
	export let categories;
	export let params;
</script>

<div class=" mt-3 space-y-3 md:space-y-6 md:mt-6 ">
	<GalleryFilters {categories} {params} />
	<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
		{#each gallery as work}
			<WorkPreview {work} />
		{/each}
	</ul>
</div>
