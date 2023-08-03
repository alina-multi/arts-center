<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import WorkBody from '$lib/components/work/page/body/WorkBody.svelte';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import SubmitButton from '$lib/components/input/SubmitButton.svelte';
	import CancelLinkButton from '$lib/components/input/CancelLinkButton.svelte';
	import Divider from '$lib/components/atoms/Divider.svelte';
	import { enhance } from '$app/forms';
	import { localePath } from '$lib/translations';
	import DateInput from '$lib/components/input/DateInput.svelte';

	export let data: PageData;
	export let form: ActionData;
	const currentDate = new Date().toISOString().split('T')[0];
	// 60 days months in advance max
	const maxDate = new Date(Date.now() + 60 * 60 * 24 * 60 * 1000).toISOString().split('T')[0];
</script>

<WorkAddProgressSteps currentStep="3" id={data.work.id} />
<form method="post" use:enhance>
	<FormGroup h1="Ready to publish?" class="my-5">
		<div class="columns-3">
			<CancelLinkButton
				href={localePath(`/my/work/draft/${data.work.id}`)}
				class="block text-center"
			>
				Back to edit
			</CancelLinkButton>
			<DateInput value={currentDate} min={currentDate} max={maxDate} name="published_at" />
			<SubmitButton class="block w-full">Publish</SubmitButton>
		</div>
	</FormGroup>
</form>
<Divider>This is how your work will look like in the gallery</Divider>
<ul
	class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 lg:gap-3"
>
	<WorkPreview work={data.work} />
</ul>
<Divider>This is how your work page will look</Divider>
<WorkBody {...data} />
