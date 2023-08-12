<script>
	import { Popover, PopoverButton, PopoverPanel, Transition } from '@rgossiaux/svelte-headlessui';

	export let style = 'right-0 ';
</script>

<Popover let:open class="relative  z-30 ">
	<PopoverButton>
		<slot name="button" />
	</PopoverButton>

	{#if open}
		<Transition
			enter="transition duration-100 ease-out"
			enterFrom="transform scale-95 opacity-0"
			enterTo="transform scale-100 opacity-100"
			leave="transition duration-75 ease-out"
			leaveFrom="transform scale-100 opacity-100"
			leaveTo="transform scale-95 opacity-0"
		>
			<PopoverPanel
				let:close
				class="absolute {style}  py-2 rounded-md  text-zinc-600 dark:text-white   bg-white  dark:bg-zinc-800 shadow-2xl ring-1 ring-black dark:ring-zinc-700 ring-opacity-5 focus:outline-none overflow-hidden "
			>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<div on:click={() => close()}>
					<slot name="panel" />
				</div>
			</PopoverPanel>
		</Transition>
	{/if}
</Popover>
