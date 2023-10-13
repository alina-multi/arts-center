<script lang='ts'>
	import Steps from '$lib/components/nav/Steps.svelte';
	import { localePath, t } from '$lib/translations';

	export let currentStep = 1,
		id: string | boolean = false;
	const steps = [
		{ label: $t('my.add_work_page.step_1'), href: id ? localePath(`/my/work/${id}/images`) : localePath('/my/work/add') },
		{ label: $t('my.add_work_page.step_2'), href: id ? localePath(`/my/work/${id}/main`) : undefined },
		{ label: $t('my.add_work_page.step_3'), href: id ? localePath(`/my/work/${id}/form`) : undefined },
		{ label: $t('my.add_work_page.step_4'), href: id ? localePath(`/my/work/${id}/preview`) : undefined }
	];
</script>

<Steps {steps} {currentStep} />
