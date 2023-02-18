<script lang="ts">
	import {
		Dialog,
		DialogOverlay,
		DialogDescription,
		DialogTitle,
		Transition,
		TransitionChild
	} from '@rgossiaux/svelte-headlessui';
	export let open: boolean;
</script>

<Transition show={open}>
	<Dialog {open} on:close={() => (open = false)} class="relative z-10">
		<TransitionChild
			enter="ease-out duration-300"
			enterFrom="opacity-0"
			enterTo="opacity-100"
			leave="ease-in duration-200"
			leaveFrom="opacity-100"
			leaveTo="opacity-0"
		>
			<DialogOverlay class="fixed inset-0 bg-zinc-400 bg-opacity-75 transition-opacity" />
		</TransitionChild>

		<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
			<TransitionChild
				enter="ease-out duration-300"
				enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
				enterTo="opacity-100 translate-y-0 sm:scale-100"
				leave="ease-in duration-200"
				leaveFrom="opacity-100 translate-y-0 sm:scale-100"
				leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
			>
				<DialogDescription
					class="relative transform overflow-hidden rounded-lg bg-white dark:bg-zinc-900 dark:text-zinc-100 p-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
				>
					<div class="flex flex-col gap-3 justify-center">
						<DialogTitle as="h3" class=" text-center text-lg font-medium leading-6">
							<slot name="header" />
						</DialogTitle>
						<slot name="main" />
						<slot name="footer" />
					</div></DialogDescription
				>
			</TransitionChild>
		</div></Dialog
	>
</Transition>
