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
	import {t} from '$lib/translations';

	export let option, selectedOrder, params, type, urlGenerator;
</script>

<Listbox value={selectedOrder} class="relative inline-block text-left z-30" let:open>
	<ListboxButton
		class=" inline-flex space-x-2 justify-center items-center  border dark:border-zinc-800 dark:bg-zinc-900 px-4 py-2 rounded-md text-gray-900 hover:bg-gray-50 dark:hover:bg-zinc-700  hover:shadow-lg dark:text-white focus:outline-none focus-visible:ring-2 dark:focus-visible:ring-white/75
		{selectedOrder != 'popular' ? ' shadow-sm' : ''}"
	>
		<span>{$t(`global.filters.${selectedOrder}`)}</span>

		<Icon src={open ? ChevronUp : ChevronDown} class="w-5" />
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
			class="absolute left-0 z-10 mt-2 w-40 origin-top-left rounded-sm bg-white dark:bg-zinc-900 shadow-2xl ring-1 ring-black dark:ring-zinc-800 ring-opacity-5 focus:outline-none overflow-hidden"
			role="menu"
		>
			{#each option as { title }}
				<ListboxOption let:selected value={title}>
					<a
						href={urlGenerator(type, title, params)}
						class=" block px-4 py-2 border-l-2 {selected
							? ' bg-gray-100 dark:text-white  dark:bg-zinc-800  border-amber-500'
							: 'text-gray-900 dark:text-zinc-300 hover:bg-gray-50/50  hover:text-gray-600 border-transparent hover:border-gray-300 dark:hover:border-zinc-700 dark:hover:text-white  dark:hover:bg-zinc-800/30'}"
						>
						<!-- {title} -->
						{$t(`global.filters.${title}`)}
						</a
					>
				</ListboxOption>
			{/each}
		</ListboxOptions>
	</Transition>
</Listbox>
