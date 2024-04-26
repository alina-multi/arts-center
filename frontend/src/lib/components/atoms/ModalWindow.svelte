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
		<DialogOverlay
			class="  fixed inset-0 bg-black/85 dark:bg-black/30 backdrop-blur-sm  transition-opacity min-h-screen overflow-y-scroll xs:px-12 sm:px-16 "
		>
			<button
				on:click={onClose}
				class="{closeButtonAddStyle}  pr-3 fixed top-0 left-0 w-full h-12 z-50 cursor-pointer"
			>
				<div bind:this={closeButton} class="flex w-full h-full justify-end items-center">
					<Icon src={XMark} class="w-6 h-6 xs:w-8 xs:h-8 " />
				</div>
			</button>

			<slot name="otherEl" />

			<DialogDescription
				class="dark:border   {clazz} mx-auto  bg-white  items-end justify-center sm:items-center transform overflow-y-auto  dark:bg-zinc-950 dark:border-zinc-800 dark:text-zinc-300 transition-all  "
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
