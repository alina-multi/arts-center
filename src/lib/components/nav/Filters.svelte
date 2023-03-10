<script lang="ts">
	import {
		Listbox,
		ListboxButton,
		ListboxOptions,
		ListboxOption,
		Dialog,
		DialogOverlay,
		Disclosure,
		DisclosureButton,
		DisclosurePanel,
		Popover,
		PopoverButton,
		PopoverGroup,
		PopoverPanel,
		Transition,
		TransitionChild
	} from '@rgossiaux/svelte-headlessui';

	import { Checkbox, Chevron } from 'flowbite-svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronDown, XMark } from '@steeze-ui/heroicons';

	export let label, options, filters;
	let isOpen = false;
	let activeFilters = [];

	let selectedOption = { name: 'All', value: 'all' };
	let name = selectedOption.name;
	let value = selectedOption.value;
</script>

<section aria-labelledby="filter-heading">
	<h2 id="filter-heading" class="sr-only">Filters</h2>
	<div class="border-b border-zinc-200 py-4 bg-white dark:bg-zinc-900 dark:border-zinc-700 ">
		<div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
			<Listbox
				value={selectedOption}
				on:change={(e) => (selectedOption = e.detail)}
				class="relative inline-block text-left"
			>
				<ListboxButton
					class="group inline-flex justify-center items-center text-sm font-medium text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-zinc-100"
				>
					<Chevron>{selectedOption.name}</Chevron>
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
						{#each options as option (option.value)}
							<ListboxOption
								class={({ active }) => (active ? 'bg-zinc-100 dark:bg-zinc-900  ' : '')}
								value={option}
								let:selected
							>
								<a
									href="#"
									class="{selected
										? 'font-medium text-zinc-900 dark:text-white'
										: 'text-zinc-600 dark:text-zinc-300'} block px-4 py-2 text-sm">{option.name}</a
								>
							</ListboxOption>
						{/each}
					</ListboxOptions>
				</Transition>
			</Listbox>

			<!-- Mobile filter dialog toggle, controls the 'mobileFiltersOpen' state. -->

			<button
				type="button"
				on:click={() => (isOpen = !isOpen)}
				class="inline-block text-sm font-medium text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white dark:border dark:py-1 dark:px-4 dark:rounded-full dark:hover:bg-black/60 sm:hidden"
				>Filters</button
			>
			<!-- Desktop filters -->
			<div class="hidden sm:block">
				<div class="flow-root">
					<PopoverGroup class="-mx-4 flex items-center divide-x divide-zinc-700">
						{#each filters as section (section.id)}
							<Popover class="relative inline-block px-4 text-left">
								<PopoverButton
									class="group inline-flex justify-center items-center text-sm font-medium text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white dark:border dark:py-1 dark:px-4 dark:rounded-full dark:hover:bg-black/60 "
								>
									<Chevron>{section.name}</Chevron>
								</PopoverButton>

								<Transition
									as="span"
									enter="transition ease-out duration-100"
									enterFrom="transform opacity-0 scale-95"
									enterTo="transform opacity-100 scale-100"
									leave="transition ease-in duration-75"
									leaveFrom="transform opacity-100 scale-100"
									leaveTo="transform opacity-0 scale-95"
								>
									<PopoverPanel
										class="absolute origin-top-right right-0 z-10 mt-2 rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none dark:ring-zinc-500 dark:bg-black/80"
									>
										<form class="space-y-4">
											{#each section.options as option (option.value)}
												<div class="flex items-center">
													<Checkbox
														bind:group={activeFilters}
														value={option.value}
														color="green"
														checked={option.checked}
													>
														<span
															class="ml-3 whitespace-nowrap pr-6 text-sm font-medium text-grey-900 dark:text-zinc-300 dark:hover:text-white  "
															>{option.label}</span
														>
													</Checkbox>
												</div>
											{/each}
										</form>
									</PopoverPanel>
								</Transition>
							</Popover>
						{/each}
					</PopoverGroup>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Mobile Filter Menu -->
<Transition show={isOpen}>
	<Dialog open={isOpen} on:close={() => (isOpen = false)} class="relative z-40 sm:hidden">
		<TransitionChild
			enter="transition-opacity ease-linear duration-300"
			enterFrom="opacity-0"
			enterTo="opacity-100"
			leave="transition-opacity ease-linear duration-300"
			leaveFrom="opacity-100"
			leaveTo="opacity-0"
		>
			<DialogOverlay class="fixed inset-0 bg-black bg-opacity-25" />
		</TransitionChild>

		<div class="fixed inset-0 grid">
			<TransitionChild
				enter="transition ease-in-out duration-300 transform"
				enterFrom="translate-x-full"
				enterTo="translate-x-0"
				leave="transition ease-in-out duration-300 transform"
				leaveFrom="translate-x-0"
				leaveTo="translate-x-full"
			>
				<div
					class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white dark:bg-zinc-900 py-4 pb-12 shadow-xl"
				>
					<div class="flex items-center justify-between px-4">
						<h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Filters</h2>
						<button
							on:click={() => (isOpen = false)}
							type="button"
							class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md p-2 text-zinc-400 dark:text-zinc-100"
						>
							<span class="sr-only">Close menu</span>
							<Icon src={XMark} class="h-6 w-6" />
						</button>
					</div>

					<form class="mt-4">
						{#each filters as section (section.id)}
							<Disclosure class="border-t border-zinc-200 dark:border-zinc-500 px-4 py-6">
								<h3 class="-mx-2 -my-3 flow-root">
									<DisclosureButton
										class="flex w-full items-center justify-between  px-2 py-3 text-sm text-zinc-400"
									>
										<span class="font-medium text-zinc-900 dark:text-zinc-100">{section.name}</span>
										<span class="ml-6 flex items-center">
											<Icon src={ChevronDown} class="h-5 w-5" />
										</span>
									</DisclosureButton>
								</h3>

								<DisclosurePanel class="pt-6">
									<div class="space-y-6">
										{#each section.options as option (option.value)}
											<div class="flex items-center">
												<Checkbox
													bind:group={activeFilters}
													value={option.value}
													color="green"
													checked={option.checked}
												>
													<span class="ml-3 text-sm text-gray-500 dark:text-zinc-300 font-normal"
														>{option.label}</span
													>
												</Checkbox>
											</div>
										{/each}
									</div>
								</DisclosurePanel>
							</Disclosure>
						{/each}
					</form>
				</div>
			</TransitionChild>
		</div>
	</Dialog>
</Transition>

<!-- Active filters -->
{#if activeFilters.length > 0}
	<div class="bg-gray-100 dark:bg-zinc-900">
		<div class="mx-auto max-w-7xl py-3 px-4 sm:flex sm:items-center sm:px-6 lg:px-8">
			<h3 class="text-sm font-medium text-gray-500 dark:text-zinc-300">
				Filters
				<span class="sr-only">, active</span>
			</h3>
			<div aria-hidden="true" class="hidden h-5 w-px bg-gray-300 sm:ml-4 sm:block" />

			<div class="mt-2 sm:mt-0 sm:ml-4">
				<div class="-m-1 flex flex-wrap items-center">
					{#each activeFilters as item (item)}
						<span
							class="m-1 inline-flex items-center rounded-full border border-zinc-200 bg-white dark:bg-zinc-200 py-1.5 pl-3 pr-2 text-sm font-medium text-zinc-900"
						>
							<span>{item}</span>
							<button
								on:click={(e) =>
									(activeFilters = activeFilters.filter((item) => item !== e.currentTarget.value))}
								value={item}
								type="button"
								class="ml-1 inline-flex flex-shrink-0 rounded-full p-1 text-zinc-400 hover:bg-zinc-200 hover:text-zinc-500"
							>
								<span class="sr-only">Remove filter for {item}</span>
								<Icon src={XMark} class="h-4 w-4" />
							</button>
						</span>
					{/each}
				</div>
			</div>
		</div>
	</div>
{/if}
