<script lang="ts">
	import type { PageData } from './$types';
	import { t } from '$lib/translations';
	import Gallery from '$lib/components/work/Gallery.svelte';
	export let data: PageData;
</script>

<Gallery gallery={data.gallery} />
