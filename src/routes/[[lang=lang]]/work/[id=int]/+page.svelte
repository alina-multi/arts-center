<script lang="ts">
	import type { PageData } from './$types';
	import WorkPage from '$lib/components/work/WorkPage.svelte';

	export let data: PageData;
</script>

<WorkPage work={data.work} />
