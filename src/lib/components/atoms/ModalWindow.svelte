<script lang="ts">
	import {
		Dialog,
		DialogDescription,
		DialogOverlay,
		DialogTitle
	} from '@rgossiaux/svelte-headlessui';

	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	export let open: boolean;
	let clazz = '';
	export {clazz as class};

	function onClose() {
		dispatch('close');
		open = false;
	}
</script>

{#if open}
<Dialog bind:open={open} on:close={onClose} class="relative z-50">
	<DialogOverlay
		class="fixed inset-0 bg-gray-200/60 dark:bg-black/30 backdrop-blur-sm transition-opacity h-screen overflow-y-scroll"
	>
		<DialogDescription
			class="mx-auto z-10 items-end justify-center sm:items-center transform overflow-y-auto  bg-white dark:bg-zinc-900 dark:text-zinc-300 transition-all  {clazz}"
		>
			<div class="flex flex-col gap-3">
				{#if $$slots.header}
					<DialogTitle as="h3" class="text-lg font-medium leading-6 ">
						<slot name="header" />
					</DialogTitle>
				{/if}
				<slot />
				{#if $$slots.footer}
					<slot name="footer" />
				{/if}
			</div>
		</DialogDescription>
	</DialogOverlay>
</Dialog>
{/if}
