<script lang="ts">
	import { Disclosure, DisclosureButton, DisclosurePanel } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronUp } from '@steeze-ui/heroicons';

	export let params, options, group, urlGenerator;
	$: selected = params[group];
</script>

<Disclosure class="py-3" let:open>
	<DisclosureButton
		class="w-full text-xs sm:text-sm lg:text-base text-gray-800 flex items-center justify-between gap-3 hover:text-gray-900"
	>
		<div class="flex gap-1 items-center">
			<span>{group}</span>
			<span>:</span>
			<div
				class=" ml-2 inline-flex items-center gap-2 text-gray-700 border-amber-600 rounded-full border px-3"
			>
				<span>{selected}</span>
			</div>
		</div>
		<Icon src={ChevronUp} class="w-4 sm:w-5  transition-all {open ? 'rotate-180' : ''}" />
	</DisclosureButton>

	<DisclosurePanel class="mt-3 py-3  max-h-96 overflow-scroll border rounded-sm" let:close>
		<ul class="flex flex-col text-sm">
			{#each options as { title }}
				<li
					class=" flex  px-3 cursor-pointer py-1 hover:bg-gray-100 {title === selected
						? 'bg-gray-100 hover:bg-gray-100  '
						: 'text-gray-800 dark:text-gray-200'}"
				>
					<a href={urlGenerator(params, { [group]: title })} class="flex grow">
						<span>{title}</span>
					</a>
				</li>
			{/each}
		</ul>
	</DisclosurePanel>
</Disclosure>
