<script lang="ts">
	import ModalWindow from '../atoms/ModalWindow.svelte';
	import { t } from '$lib/translations';
	import ButtonsGroup from '../forms/ButtonsGroup.svelte';
	import ActionButton from '../forms/ActionButton.svelte';
	import CancelButton from '../forms/CancelButton.svelte';
	import AuthModal from '../atoms/AuthModal.svelte';
	import { user } from '$lib/stores/auth';

	export let open: boolean,
		condition: boolean,
		length: number = 0,
		submitFromList: () => Promise<void>,
		submiInput: () => Promise<void>;
</script>

{#if $user}
	<ModalWindow bind:open>
		<div class="flex items-center justify-between mb-3">
			<slot name="header" />
		</div>

		<form on:submit={condition ? submiInput : submitFromList} class="flex flex-col gap-6">
			{#if length > 0}
				<div
					class="relative   border-gray-200 dark:border-zinc-800 space-y-3 "
				>
					<slot name="list" />
				</div>
			{/if}

			{#if condition}
				<div class="relative dark:border-zinc-800 dark:border rounded-sm ">
					<slot name="showInput" />
				</div>
			{/if}

			<ButtonsGroup>
				<CancelButton bind:open />
				<ActionButton
					type="submit"
					class={'bg-blue-500 hover:bg-blue-400 focus-visible:outline-blue-600 flex items-center gap-1'}
				>
					{$t('global.buttons.send')}
				</ActionButton>
			</ButtonsGroup>
		</form>
	</ModalWindow>
{:else}
	<AuthModal bind:open type={$t('global.report.title').toLowerCase()} />
{/if}
