<script lang="ts">
	import type { PageData } from './$types';
	import DraftPreview from '$lib/components/work/DraftPreview.svelte';

	export let data: PageData;
</script>

<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-3">
	{#each data.gallery as draft}
		<li class="relative rounded-sm overflow-hidden">
			<DraftPreview {draft} />
		</li>
	{/each}
</ul>
