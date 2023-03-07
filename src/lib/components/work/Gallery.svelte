<script lang="ts">
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	export let gallery;
</script>

<ul class=" p-3 mt-2  grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
	{#each gallery as work}
		<WorkPreview {work} />
	{/each}
</ul>
