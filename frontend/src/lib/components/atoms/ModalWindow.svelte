<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { XMark } from '@steeze-ui/heroicons';
	import {
		Dialog,
		DialogDescription,
		DialogOverlay,
		DialogTitle
	} from '@rgossiaux/svelte-headlessui';

	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	export let open: boolean,
		closeButtonAddStyle = 'text-white ';
	let clazz = '';
	export { clazz as class };

	let closeButton = null;

	function onClose() {
		dispatch('close');
		open = false;
	}
</script>

{#if open}
	<Dialog initialFocus={closeButton} bind:open on:close={onClose} class="relative z-50 ">
		<button
			on:click={onClose}
			class=" px-3 md:px-6 fixed top-0 right-2 h-12 z-50 cursor-pointer {closeButtonAddStyle} "
		>
			<div bind:this={closeButton} class="flex w-full h-full justify-end items-center">
				<Icon src={XMark} class="w-6 h-6  " />
			</div>
		</button>

		<slot name="otherEl" />

		<DialogOverlay
			class="  fixed inset-0 bg-black/85    min-h-screen overflow-y-scroll md:px-9 lg:px-20 xl:px-16 "
		>
			<DialogDescription
				class="dark:border static  {clazz} mx-auto  bg-white   items-end justify-center sm:items-center transform overflow-y-auto  dark:bg-zinc-950 dark:border-0 dark:sm:border-zinc-800 dark:text-zinc-300  "
			>
				<div class="flex flex-col gap-3">
					{#if $$slots?.header}
						<DialogTitle as="h3" class="text-lg font-medium leading-6 ">
							<slot name="header" />
						</DialogTitle>
					{/if}
					<slot />
					{#if $$slots?.footer}
						<slot name="footer" />
					{/if}
				</div>
			</DialogDescription>
		</DialogOverlay>
	</Dialog>
{/if}
