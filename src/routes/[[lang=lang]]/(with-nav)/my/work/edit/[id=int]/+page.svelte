<script lang="ts">
	import type { PageData, ActionData } from './$types';
	import { enhance } from '$app/forms';
	import WorkForm from '$lib/components/forms/WorkForm.svelte';
	import ActionButton from '$lib/components/forms/ActionButton.svelte';
	import ModalWindow from '$lib/components/ModalWindow.svelte';
	import ButtonsGroup from '$lib/components/forms/ButtonsGroup.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Trash } from '@steeze-ui/heroicons';
	import CancelButton from '$lib/components/forms/CancelButton.svelte';

	export let data: PageData;
	export let form: ActionData;
	let open = false;
</script>

<form method="POST" action="?/post" use:enhance>
	<WorkForm {data} errors={form?.errors}>
		<ButtonsGroup>
			<ActionButton
				type="button"
				class={'bg-gray-300 hover:bg-red-500 focus-visible:outline-red-600 flex items-center gap-1'}
				on:click={() => {
					open = true;
				}}
			>
				<span>Move to drafts</span>
				<Icon src={Trash} theme="solid" class="h-4 w-4" />
			</ActionButton>
			<ActionButton class={'bg-blue-600 hover:bg-blue-500 focus-visible:outline-blue-600'} />
		</ButtonsGroup>
	</WorkForm>
</form>

{#if open}
	<ModalWindow bind:open>
		<div class="font-semibold">Are you sure you want to move this work to drafts?</div>
		<div slot="footer">
			<form method="POST" action="?/todrafts">
				<ButtonsGroup>
					<CancelButton bind:open />
					<ActionButton
						class={'bg-red-500 hover:bg-red-400 focus-visible:outline-red-600 flex items-center gap-1'}
					>
						<span>Move to drafts</span>
						<Icon src={Trash} theme="solid" class="h-4 w-4" />
					</ActionButton>
				</ButtonsGroup>
			</form>
		</div>
	</ModalWindow>
{/if}
