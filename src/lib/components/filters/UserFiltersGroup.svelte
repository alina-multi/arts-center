<script lang="ts">
	import { Disclosure, DisclosureButton, DisclosurePanel } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronDown } from '@steeze-ui/heroicons';
	import { t } from '$lib/translations';
	import { unslug } from '$lib/helpers/url';
	import { locale } from '$lib/translations';

	export let params, options, group, urlGenerator;
	$: selected = unslug(params[group]);

	const regionNames = new Intl.DisplayNames([$locale], { type: 'region' });
</script>

<Disclosure let:open>
	<DisclosureButton
		class="p-6 {open
			? 'border-b dark:border-b-zinc-800'
			: ''} group w-full   text-gray-800 dark:text-white flex items-center justify-between gap-3 hover:text-gray-900 "
	>
		<div class="flex gap-1 items-center">
			<span class="text-sm text-black dark:text-white">
				{$t(`global.filters.${group}`).toUpperCase()}
			</span>
			<span>:</span>
			<div
				class=" ml-2 inline-flex items-center gap-2 border-amber-600 rounded-sm border px-3 dark:text-zinc-200 dark:bg-zinc-800"
			>
				{#if selected === 'popular' || selected === 'new'}
					{$t(`global.filters.${selected}`)}
				{:else}
					{selected === 'all'
						? $t(`global.filters.all`)
						: group === 'country'
						? regionNames.of(selected.toUpperCase())
						: selected}
				{/if}
			</div>
		</div>
		<Icon
			src={ChevronDown}
			class="w-5 group-hover:text-gray-500 dark:group-hover:text-zinc-300 transition-all {open
				? 'rotate-180'
				: ''}"
		/>
	</DisclosureButton>

	<DisclosurePanel class=" max-h-96 overflow-x-auto dark:border-zinc-900 dark:border" let:close>
		<ul class="flex flex-col dark:bg-zinc-800 text-sm">
			{#each options as option (option.title)}
				<li>
					<a
						href={urlGenerator(params, { [group]: option.value ?? option.title })}
						on:click={() => close()}
						class="flex w-full cursor-pointer py-3 px-6 {option.title === selected
							? 'bg-gray-100 hover:bg-gray-100 dark:border-l dark:border-amber-500  dark:bg-zinc-700 '
							: 'text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-700 '}"
					>
						<span>
							{#if option.title === 'popular' || option.title === 'new'}
								{$t(`global.filters.${option.title}`)}
							{:else}
								{option.title}
							{/if}
						</span>
						{#if option.count}
							<span class="ml-auto text-gray-500">{option.count}</span>
						{/if}
					</a>
				</li>
			{/each}
		</ul>
	</DisclosurePanel>
</Disclosure>
