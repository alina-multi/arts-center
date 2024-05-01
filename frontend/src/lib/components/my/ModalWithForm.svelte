<script lang="ts">
	import ModalWindow from '../atoms/ModalWindow.svelte';
	import ButtonsGroup from '../forms/ButtonsGroup.svelte';
	import ActionButton from '../forms/ActionButton.svelte';
	import CancelButton from '../forms/CancelButton.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');
	export let open: boolean,
		condition: boolean,
		length: number = 0,
		action_button = 'send',
		submitFromList: () => Promise<void>,
		submiInput: () => Promise<void>;
</script>


	<ModalWindow
		bind:open
		class="xl:w-1/3 rounded-sm my-24  xs:max-sm:mx-6 sm:max-md:mx-9 md:w-2/3 lg:w-1/2"
	>
		<div class="flex items-center justify-between mb-3 py-6 px-9 border-b dark:border-zinc-800">
			<slot name="header" />
		</div>

		<form
			on:submit|preventDefault={condition ? submiInput : submitFromList}
			class="flex flex-col gap-6 pb-6 px-9"
		>
			{#if length > 0}
				<div class="relative border-zinc-200 dark:border-zinc-800 space-y-6">
					<slot name="list" />
				</div>
			{/if}

			{#if condition}
				<div class="relative rounded-sm">
					<slot name="showInput" />
				</div>
			{/if}

			<ButtonsGroup>
				<CancelButton bind:open />
				<ActionButton
					type="submit"
					class={'bg-blue-500 hover:bg-blue-400 focus-visible:outline-blue-600 flex items-center gap-1'}
				>
					{$t(`global.buttons.${action_button}`)}
				</ActionButton>
			</ButtonsGroup>
		</form>
	</ModalWindow>

