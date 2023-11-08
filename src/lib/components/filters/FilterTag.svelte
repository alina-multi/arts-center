<script lang="ts">
	import type { Tag } from '$lib/interfaces/Tag';
	import { Popover, PopoverButton, PopoverPanel, Transition } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronDown, ChevronUp, AdjustmentsHorizontal } from '@steeze-ui/heroicons';
	import TagButtons from '$lib/components/atoms/buttons/TagButtons.svelte';
	import { t } from '$lib/translations';
	import { slug } from '$lib/helpers/url.js';

	export let tags: Tag[],
		selected: string,
		params: { tag: string; order: string } | { tag: string, username: string} ,
		urlGenerator;

	let visibleTags, hiddenTags;

	$: if (tags.length > 6) {
		visibleTags = tags.slice(0, 6);
		hiddenTags = tags.slice(6);
	} else {
		visibleTags = tags;
		hiddenTags = [];
	}

	$: isHiddenTag = hiddenTags?.filter((tag) => tag?.title === selected);

	$: isActive = (tag: string) => {
		return slug(tag) === selected;
	};
</script>

<!-- DESkTOP -->
<div class="hidden lg:flex">
	<Popover class="relative inline-block text-left  z-20 text-black  dark:text-white" let:open>
		<div class="flex flex-wrap gap-3 lg:justify-end w-full">
			<TagButtons tags={visibleTags} {urlGenerator} {params} active={isActive} {selected} />

			{#if hiddenTags.length > 0}
				<PopoverButton
					class="flex items-center gap-2  border px-3 py-1 rounded-sm hover:border-amber-500 dark:bg-zinc-900 dark:border-zinc-800 dark:hover:border-amber-500"
				>
					{$t('global.filters.more')}
				
					{#if selected !== 'all' && isHiddenTag.length > 0}
						<span class="text-sm bg-amber-600 text-white px-1 rounded-sm">{selected}</span>
					{/if}
					{#if !open}
						<Icon src={ChevronUp} class="w-5 transform rotate-180" />
					{/if}
					{#if open}
						<Icon src={ChevronDown} class="w-5 transform rotate-180" />
					{/if}
				</PopoverButton>
			{/if}
		</div>

		{#if hiddenTags.length > 0}
			<Transition
				show={open}
				enter="transition ease-out duration-100"
				enterFrom="transform opacity-0 scale-95"
				enterTo="transform opacity-100 scale-100"
				leave="transition ease-in duration-75"
			>
				<PopoverPanel
					class="absolute left-0 z-10 mt-2 origin-top-left w-full rounded-sm bg-white dark:bg-black/90 shadow-2xl ring-1 ring-black dark:ring-zinc-900 ring-opacity-5 focus:outline-none overflow-hidden"
					let:close
				>
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<!-- svelte-ignore a11y-no-static-element-interactions -->
					<div class="flex gap-3 flex-wrap flex-row-reverse p-3" on:click={() => close()}>
						<TagButtons tags={hiddenTags} {urlGenerator} {params} active={isActive} />
					</div>

					{#if selected !== 'all'}
						<button on:click={() => (selected = 'all')} class="w-full text-right pb-6 pr-3">
							<span
								class=" text-zinc-400  hover:text-red-600 px-3 py-0.5 text-sm underline"
								>{$t('global.buttons.clear') + ' ' + $t('global.filters.filters')}</span
							>
						</button>
					{/if}
				</PopoverPanel>
			</Transition>
		{/if}
	</Popover>
</div>

<!-- MOBILE -->
<div class="flex lg:hidden text-left z-20 flex-row-reverse">
	<Popover class=" w-full flex-1  text-black dark:text-zinc-200  " let:open>
		<PopoverButton
			class="w-full flex items-center justify-between gap-2  border px-4 py-2 rounded-sm  dark:border-zinc-800 overflow-hidden dark:bg-zinc-900"
		>
<div class="flex items-center gap-3">
	<Icon src={AdjustmentsHorizontal} class="w-5" />

		<span>{$t('global.filters.filters')}</span>
		{#if selected !== 'all'}
			<span class="text-sm bg-amber-600 text-white px-1 py-0.5 rounded-sm">{selected}</span>
		{/if}
	
</div>
	
			{#if !open}
				<Icon src={ChevronDown} class="w-5" />
			{/if}
			{#if open}
				<Icon src={ChevronUp} class="w-5" />
			{/if}
		</PopoverButton>

		<PopoverPanel
			class="absolute  right-0  z-10 mt-3  bg-white/90 backdrop-blur-md dark:bg-black/90 shadow-2xl ring-1 ring-black dark:ring-zinc-800 ring-opacity-5 focus:outline-none overflow-hidden"
			let:close
		>
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-static-element-interactions -->
			<div class="flex gap-2 flex-wrap text-sm p-4 flex-row-reverse" on:click={() => close()}>
				<TagButtons {tags} {urlGenerator} {params} active={isActive} />
			</div>
			{#if selected !== 'all'}
				<button
					on:click={() => (selected = 'all')}
					class="w-full text-right pt-3 pb-6 px-3 border-t border-gray-300 dark:border-zinc-900"
				>
				<span
				class=" text-zinc-400  hover:text-red-600 px-3 py-0.5 text-sm hover:underline"
				>{$t('global.buttons.clear') + ' ' + $t('global.filters.filters')}</span
			>
				</button>
			{/if}
		</PopoverPanel>
	</Popover>
</div>
