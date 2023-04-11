<script lang="ts">
	import { Popover, PopoverButton, PopoverPanel, Transition } from '@rgossiaux/svelte-headlessui';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronDown, ChevronUp } from '@steeze-ui/heroicons';
	import TagButtons from '$lib/components/atoms/TagButtons.svelte';
	import TagButton from '$lib/components/atoms/TagButton.svelte';

	export let tags, href: string, selectedTag: string, onTag: (tag: string) => void;
	let visibleTags, hiddenTags;
	$: if (tags.length > 8) {
		visibleTags = tags.slice(0, 8);
		hiddenTags = tags.slice(8);
	} else {
		visibleTags = tags;
		hiddenTags = [];
	}

	$: isHiddenTag = hiddenTags.filter((tag) => tag.title === selectedTag);

	$: isActive = (tag: string) => {
		return tag === selectedTag;
	};
</script>

<!-- DESkTOP -->
<div class="hidden md:block">
	<Popover class="relative inline-block text-left z-50 text-gray-800 dark:text-gray-200" let:open>
		<div class="flex flex-wrap  gap-3 ">
			<TagButton {href} clickHandler={() => onTag('all')} active={isActive('all')} title={'all'} />
			<TagButtons tags={visibleTags} {href} clickHandler={onTag} active={isActive} />
			{#if hiddenTags.length > 0}
				<PopoverButton
					class="flex items-center gap-2  border px-3 py-1 rounded-md hover:border-amber-500 "
				>
					other
					{#if selectedTag !== 'all' && isHiddenTag.length > 0}
						<span class="text-sm bg-amber-600 text-white px-1 rounded-md">{selectedTag}</span>
					{/if}
					{#if !open}
						<Icon src={ChevronDown} class="w-5" />
					{/if}
					{#if open}
						<Icon src={ChevronUp} class="w-5" />
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
					class="absolute left-0 z-10 mt-2 origin-top-left rounded-md bg-white dark:bg-black/90 shadow-2xl ring-1 ring-black dark:ring-zinc-500 ring-opacity-5 focus:outline-none overflow-hidden"
					let:close
				>
					<!-- svelte-ignore a11y-click-events-have-key-events -->
					<div class="flex  gap-3 flex-wrap flex-row-reverse p-3" on:click={() => close()}>
						<TagButtons tags={hiddenTags} {href} clickHandler={onTag} active={isActive} />
					</div>
				</PopoverPanel>
			</Transition>
		{/if}
	</Popover>
</div>

<!-- MOBILE -->
<div class="flex md:hidden  text-left z-50 flex-row-reverse">
	<Popover class=" inline-block   text-gray-800 dark:text-gray-200 " let:open>
		<div class="flex flex-wrap gap-3 ">
			<PopoverButton
				class="flex items-center gap-2  border px-4 py-2 rounded-md hover:border-amber-500 "
			>
				filters
				{#if selectedTag !== 'all'}
					<span class="text-sm bg-amber-600 text-white px-1 rounded-md">{selectedTag}</span>
				{/if}
				{#if !open}
					<Icon src={ChevronDown} class="w-5" />
				{/if}
				{#if open}
					<Icon src={ChevronUp} class="w-5" />
				{/if}
			</PopoverButton>
		</div>

		<PopoverPanel
			class="absolute origin-top-right right-0 w-full  z-10 mt-2 rounded-md bg-white dark:bg-black/90 shadow-2xl ring-1 ring-black dark:ring-zinc-500 ring-opacity-5 focus:outline-none overflow-hidden"
		>
			<div class="flex  gap-2 flex-wrap text-sm  p-3 flex-row-reverse ">
				<TagButton
					{href}
					clickHandler={() => onTag('all')}
					active={isActive('all')}
					title={'all'}
				/>
				<TagButtons {tags} {href} clickHandler={onTag} active={isActive} />
			</div>
		</PopoverPanel>
	</Popover>
</div>
