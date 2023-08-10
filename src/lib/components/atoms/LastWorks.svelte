<script lang="ts">
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	export let works;
</script>

<div class="grid grid-cols-3 gap-1 overflow-hidden w-full">
	{#each works as work}

	<div><ImageWork {work} /></div>	
	{/each}
</div>
