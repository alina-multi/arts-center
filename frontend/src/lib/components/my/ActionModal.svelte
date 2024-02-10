<script lang="ts">
	import ModalWindow from '../atoms/ModalWindow.svelte';
	import ActionButton from '../forms/ActionButton.svelte';
	import ButtonsGroup from '../forms/ButtonsGroup.svelte';
	import CancelButton from '../forms/CancelButton.svelte';
	export { clazz as class };
	let clazz: string = 'bg-red-500 hover:bg-red-400 focus-visible:outline-red-600 ';

	export let open: boolean, action: () => void, actionName: string;
</script>

<ModalWindow
	bind:open
	class="xl:w-1/3 rounded-sm my-24  xs:max-sm:mx-6 sm:max-md:mx-9 md:w-2/3 lg:w-1/2 px-9 py-9"
>
	<slot name="header">
		<slot name="title" class="font-semibold " />
	</slot>
	<slot />

	<div slot="footer" class="mt-6">
		<ButtonsGroup>
			<CancelButton bind:open />
			<ActionButton type="button" on:click={() => action()} class={clazz}>
				{actionName}
			</ActionButton>
		</ButtonsGroup>
	</div>
</ModalWindow>
