<script lang='ts'>
	import Steps from '$lib/components/nav/Steps.svelte';
	import { localePath, t } from '$lib/translations';


	export let currentStep = 1,
		id: string | boolean = false;
	const steps = [
		{ label: $t('my.add_work_page.step_1'), href: localePath('/my/work/add') },
		{ label: $t('my.add_work_page.step_2'), href: id ? localePath(`/my/work/draft/${id}`) : undefined },
		{ label: $t('my.add_work_page.step_3') }
	];
</script>

<Steps {steps} {currentStep} />
