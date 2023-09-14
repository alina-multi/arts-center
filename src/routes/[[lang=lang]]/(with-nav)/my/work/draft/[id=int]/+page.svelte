<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import WorkForm from '$lib/components/forms/WorkForm.svelte';
	import Cropper from 'svelte-easy-crop';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import { enhance } from '$app/forms';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';
	import CancelButton from '$lib/components/forms/CancelButton.svelte';
	import {  t } from '$lib/translations';


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
	<div class="columns-2 flex flex-col gap-3">
	
		<FormGroup h1={$t('my.add_work_page.crop_label')}>
			<div class="relative h-80 w-11/12 mx-auto">
				<Cropper image={data?.full?.src} aspect={4 / 3} on:cropcomplete={cropComplete} />
				<input type="hidden" name="crop" bind:value={pixels} />
			</div>
		</FormGroup>
		<WorkForm {data} errors={form?.errors}>
			<ButtonsGroup>
				<ActionButton
					type="button"
					class={'bg-gray-300 dark:bg-zinc-700 dark:text-zinc-500 hover:bg-red-500 focus-visible:outline-red-600 flex items-center gap-1'}
					on:click={() => {
						open = true;
					}}
				>
					{$t('my.buttons.delete_draft')}
				</ActionButton>
				<ActionButton class={'bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600'} />
			</ButtonsGroup>
		</WorkForm>
	</div>
</form>


	<ModalWindow bind:open>
		<div class="font-semibold">{$t("my.confirmation.delete_work")}</div>
		<div class="text-sm text-gray-500 dark:text-zinc-400">{$t("my.confirmation.delete_warning")}</div>

		<div slot="footer">
			<form method="POST" action="?/delete">
				<ButtonsGroup>
					<CancelButton bind:open />
					<ActionButton
						type="submit"
						class={'bg-red-500 hover:bg-red-400 focus-visible:outline-red-600 flex items-center gap-1'}
					>
						<span>{$t('global.buttons.delete')}</span>
					</ActionButton>
				</ButtonsGroup>
			</form>
		</div>
	</ModalWindow>

