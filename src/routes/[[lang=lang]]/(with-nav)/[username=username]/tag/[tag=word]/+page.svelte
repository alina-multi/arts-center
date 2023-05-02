<script lang="ts">
	import type { PageData } from '../$types';
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	export let data: PageData;
</script>

<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  gap-3">
	{#each data.gallery as work}
		<li>
			<ImageWork {work} withDesription />
		</li>
	{/each}
</ul>
