<script lang="ts">
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	export let works;
</script>

<div class="grid grid-cols-3 md:max-lg:grid-cols-2 gap-1 overflow-hidden w-full">
	{#each works as work (work.id)}
		<div class="md:max-lg:last-of-type:hidden"><ImageWork {work} /></div>
	{/each}
</div>
