<script lang="ts">
	import ModalWindow from '../atoms/ModalWindow.svelte';
	import ActionButton from '../forms/ActionButton.svelte';
	import ButtonsGroup from '../forms/ButtonsGroup.svelte';
	import CancelButton from '../forms/CancelButton.svelte';
	export let className: string = "bg-red-500 hover:bg-red-400 focus-visible:outline-red-600 "

	export let open: boolean, action: () => void, actionName: string;
</script>

<ModalWindow bind:open>
	<slot name="header">
		<slot name="title" class="font-semibold" />
	</slot>
	<slot />

	<div slot="footer">
		<ButtonsGroup>
			<CancelButton bind:open />
			<ActionButton
				type="button"
				on:click={() => action()}
				class ={className}
			>
				{actionName}
			</ActionButton>
		</ButtonsGroup>
	</div>
</ModalWindow>
