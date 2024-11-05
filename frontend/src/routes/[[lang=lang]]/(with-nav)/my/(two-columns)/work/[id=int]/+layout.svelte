<script lang="ts">
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import { page } from '$app/stores';
	let currentStep;
	$: {
		let pathname = $page?.url?.pathname;
		currentStep = 1;
		if (pathname.endsWith('/main')) {
			currentStep = 2;
		}
		if (pathname.endsWith('/form')) {
			currentStep = 3;
		}
		if (pathname.endsWith('/preview')) {
			currentStep = 4;
		}
	}
</script>

<WorkAddProgressSteps id={$page.data.work.id} {currentStep} />
<slot />
