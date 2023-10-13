<script lang='ts'>
	import type { PageData } from './$types';
	import WorkImages from '$lib/components/my/WorkImages.svelte';
	export let data: PageData;
</script>
<WorkImages {...data}/>