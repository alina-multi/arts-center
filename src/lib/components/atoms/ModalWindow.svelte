<script lang="ts">
	import {
		Dialog,
		DialogDescription,
		DialogOverlay,
		DialogTitle,
		Transition
	} from '@rgossiaux/svelte-headlessui';

	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	export let open: boolean;
	function onClose() {
		open = false;
		dispatch('close');
	}
</script>

<Transition show={open}>
	<Dialog {open} on:close={onClose} class="relative z-50">
		<DialogOverlay
			class="fixed inset-0 bg-zinc-400 bg-opacity-30 backdrop-blur-sm transition-opacity"
		>
			<DialogDescription
				class="mx-auto my-24 z-10 w-96 items-end justify-center  sm:items-center  transform overflow-y-auto rounded-lg bg-white dark:bg-zinc-900 dark:text-zinc-300   transition-all p-6 "
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
</Transition>
