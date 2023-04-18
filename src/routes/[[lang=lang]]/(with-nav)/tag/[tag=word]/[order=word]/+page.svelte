<script lang="ts">
	import type { PageData } from './$types';
	import Gallery from '$lib/components/work/Gallery.svelte';

	export let data: PageData;
</script>

<Gallery {...data} />
