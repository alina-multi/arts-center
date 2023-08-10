<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import WorkForm from '$lib/components/forms/WorkForm.svelte';
	import Cropper from 'svelte-easy-crop';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import { enhance } from '$app/forms';
	import FormButton from '$lib/components/forms/FormButton.svelte';
	import ModalWindow from '$lib/components/ModalWindow.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';


	export let data: PageData;
	export let form: ActionData;
	let open = false;
	let pixels;

	function cropComplete(e) {
		pixels = JSON.stringify(e.detail.pixels);
	}

</script>

<WorkAddProgressSteps currentStep="2" />
<form method="POST" action="?/post" use:enhance>
	<div class="columns-2 mt-5">
		<WorkForm {data} errors={form?.errors} >
			<ButtonsGroup>
				<FormButton

					type="button"
					class={'bg-gray-300 hover:bg-red-500 focus-visible:outline-red-600 flex items-center gap-1'}
					on:click={() => {
						open = true;
					}}
				>
					<span>Delete draft</span>
				
				</FormButton>
				<FormButton class={'bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600'} />
			</ButtonsGroup>
		</WorkForm>
		<FormGroup h1="Crop image preview">
			<div class="relative h-80">
				<Cropper image={data?.full?.src} aspect={4 / 3} on:cropcomplete={cropComplete} />
				<input type="hidden" name="crop" bind:value={pixels} />
			</div>
		</FormGroup>
	</div>
</form>


{#if open}
	<ModalWindow bind:open>
		<div class="font-semibold">Are you sure you want to delete this work?</div>
		<div class="text-sm text-gray-500">This action cannot be undone.</div>

		<div slot="footer">
			<form method="POST" action="?/delete">
			<ButtonsGroup>
				<FormButton
					type="button"
					class={'bg-gray-500 hover:bg-gray-600 focus-visible:outline-gray-600'}
					on:click={() => {
						open = false;
					}}
				>
					<span>Cancel</span>
				</FormButton>
				<FormButton
				type="submit"
				 class={'bg-red-500 hover:bg-red-400 focus-visible:outline-red-600 flex items-center gap-1'}  >
					<span>Delete</span>
				</FormButton>
			</ButtonsGroup>
		</form>
		</div>

	</ModalWindow>
{/if}