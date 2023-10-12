<script lang='ts'>
	import type { PageData } from './$types';
	import WorkImages from '$lib/components/my/WorkImages.svelte';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	export let data: PageData;
</script>
<WorkAddProgressSteps />
<WorkImages {...data}/>
