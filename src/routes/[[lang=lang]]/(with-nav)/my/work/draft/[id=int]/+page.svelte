<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import WorkForm from '$lib/components/forms/WorkForm.svelte';
	import Cropper from 'svelte-easy-crop';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import { enhance } from '$app/forms';

	export let data: PageData;
	export let form: ActionData;

	let pixels;

	function cropComplete(e) {
		pixels = JSON.stringify(e.detail.pixels);
	}
</script>

<WorkAddProgressSteps currentStep="2" />
<form method="post" use:enhance>
	<div class=" space-y-3">
		<FormGroup h1="Crop image preview">
			<div class="relative h-80 w-3/4 mx-auto">
				<Cropper image={data?.full?.src} aspect={4 / 3} on:cropcomplete={cropComplete} />
				<input type="hidden" name="crop" bind:value={pixels} />
			</div>
		</FormGroup>
		<WorkForm {data} errors={form?.errors} />
	
	</div>
</form>
