<script lang="ts">
	import {
		Dialog,
		DialogOverlay,
		DialogDescription,
		DialogTitle,
		Transition
	} from '@rgossiaux/svelte-headlessui';
	export let open: boolean;
</script>

<Transition show={open}>
	<Dialog {open} on:close={() => (open = false)} class="relative z-10">
		<DialogOverlay
			class="fixed inset-0 bg-zinc-400 bg-opacity-30 backdrop-blur-sm transition-opacity"
		>
			<DialogDescription
				class="  mx-auto my-24 z-10 h-[600px] w-96 items-end justify-center  sm:items-center  transform overflow-y-auto rounded-lg bg-white   transition-all p-6 "
			>
				<div class="flex flex-col gap-3 divide-y ">
					<DialogTitle as="h3" class="  text-lg font-medium leading-6">
						<slot name="header" />
					</DialogTitle>
					<slot name="main" />
					<slot name="footer" />
				</div>
			</DialogDescription>
		</DialogOverlay>
	</Dialog>
</Transition>
