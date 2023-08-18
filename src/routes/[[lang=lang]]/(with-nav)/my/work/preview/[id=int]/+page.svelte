<script lang="ts">
	import type { PageData } from './$types';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import WorkPreview from '$lib/components/work/WorkPreview.svelte';
	import WorkBody from '$lib/components/work/page/WorkBody.svelte';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import CancelLinkButton from '$lib/components/input/CancelLinkButton.svelte';
	import Divider from '$lib/components/atoms/Divider.svelte';
	import { enhance } from '$app/forms';
	import { localePath } from '$lib/translations';
	import DateInput from '$lib/components/input/DateInput.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';

	export let data: PageData;
	const currentDate = new Date().toISOString().split('T')[0];
	// 60 days months in advance max
	const maxDate = new Date(Date.now() + 60 * 60 * 24 * 60 * 1000).toISOString().split('T')[0];
</script>

<WorkAddProgressSteps currentStep="3" id={data.work.id} />
<form method="post" use:enhance>
	<FormGroup h1="Ready to publish?" class="my-5">
		<div class=" max-md:flex max-md:flex-col md:columns-3">
			<CancelLinkButton
				href={localePath(`/my/work/draft/${data.work.id}`)}
				class="block text-center"
			>
				Back to edit
			</CancelLinkButton>
			<DateInput value={currentDate} min={currentDate} max={maxDate} name="published_at" />

			<ActionButton class="block w-full bg-blue-600 hover:bg-blue-500 ">Publish</ActionButton>
		</div>
	</FormGroup>
</form>
<Divider>This is how your work will look like in the gallery</Divider>
<ul
	class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 lg:gap-3"
>
	<WorkPreview work={data.work} />
</ul>
<Divider>This is how your work page will look</Divider>
<WorkBody {...data} />
