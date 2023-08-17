<script lang='ts'>
	import Steps from '$lib/components/nav/Steps.svelte';
	import { localePath } from '$lib/translations';

	export let currentStep = 1,
		id: string | boolean = false;
	const steps = [
		{ label: 'Upload images', href: localePath('/my/work/add') },
		{ label: 'Fill details', href: id ? localePath(`/my/work/draft/${id}`) : undefined },
		{ label: 'Preview' }
	];
</script>

<Steps {steps} {currentStep} />
