<script lang="ts">
	import {
		Listbox,
		ListboxButton,
		ListboxOption,
		ListboxOptions,
		Transition
	} from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronDown, ChevronUp } from '@steeze-ui/heroicons';

	export let option, selectedOrder, params, type, urlGenerator;
</script>

<Listbox value={selectedOrder} class="relative inline-block text-left z-40" let:open>
	<ListboxButton
		class="group inline-flex space-x-2 justify-center items-center  border px-4 py-2 rounded-md text-gray-900 hover:bg-sky-700 hover:text-white hover:shadow-sm dark:text-zinc-300 dark:hover:text-zinc-100 {selectedOrder !=
		'popular'
			? 'bg-sky-700 text-white shadow-sm'
			: ''}"
	>
		<span>{selectedOrder}</span>
		{#if open}
			<Icon src={ChevronUp} class="w-5" />
		{:else}
			<Icon src={ChevronDown} class="w-5" />
		{/if}
	</ListboxButton>

	<Transition
		enter="transition ease-out duration-100"
		enterFrom="transform opacity-0 scale-95"
		enterTo="transform opacity-100 scale-100"
		leave="transition ease-in duration-75"
		leaveFrom="transform opacity-100 scale-100"
		leaveTo="transform opacity-0 scale-95"
	>
		<ListboxOptions
			class="absolute left-0 z-10 mt-2 w-40 origin-top-left rounded-md bg-white dark:bg-black/90 shadow-2xl ring-1 ring-black dark:ring-zinc-500 ring-opacity-5 focus:outline-none overflow-hidden"
			role="menu"
		>
			{#each option as { title }}
				<ListboxOption
					class={({ active }) => (active ? 'bg-gray-100 dark:bg-zinc-900  ' : '')}
					value={title}
					let:selected
				>
					<a
						href={urlGenerator(type, title, params)}
						class={selected
							? ' bg-gray-200 dark:text-white block px-4 py-2'
							: 'text-gray-600 dark:text-zinc-300 block px-4 py-2'}>{title}</a
					>
				</ListboxOption>
			{/each}
		</ListboxOptions>
	</Transition>
</Listbox>
