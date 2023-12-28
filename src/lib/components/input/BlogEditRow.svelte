<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, Photo, Camera, Trash } from '@steeze-ui/heroicons';
	import BlogEditText from '$lib/components/input/BlogEditText.svelte';
	import BlogEditImage from '$lib/components/input/BlogEditImage.svelte';
	import BlogEditWorks from '$lib/components/input/BlogEditWorks.svelte';
	import { createEventDispatcher, getContext } from 'svelte';
	import type { Picture } from '$lib/interfaces/Picture';
	const dispatch = createEventDispatcher();

	export let row;
	export let images: Map<string, Picture>;
	export let index: number, focus: number | undefined;

	let t = getContext('t');
	let displayTypeButtons = false;

	$: displayPlus = row.type === 'text' && ['<br>', ''].includes(row.text);
	$: isFocused = index === focus;
	$: displayRowActions = isFocused && !displayPlus;

	function toggleTypeButtons() {
		displayTypeButtons = !displayTypeButtons;
	}

	function changeType(newType) {
		displayTypeButtons = false;
		if (newType === 'image') {
			dispatch('uploadImage');
		}
		if (newType === 'work') {
			dispatch('attachWorks');
		}
	}
	function removeBlock() {
		// Todo, translate and don't ask if empty, maybe use butiful confirmation not standard
		if (confirm('Are you sure you want to remove this block?')) {
			dispatch('removeBlock');
		}
	}
</script>

<div class="flex group border-zinc-100 ring-1 {isFocused ? 'ring-gray-300' : 'ring-transparent'}">
	<div class="w-16">
		{#if displayPlus}
			<button class:rotate-45={displayTypeButtons} on:click={toggleTypeButtons}>
				<Icon src={PlusCircle} class="w-6 h-6 text-gray-500" />
			</button>
		{/if}
		{#if displayRowActions}
			<button on:click={removeBlock}>
				<Icon src={Trash} class="w-6 h-6 text-red-500" />
			</button>
		{/if}
	</div>
	<div class="grow">
		{#if displayTypeButtons}
			<button on:click={() => changeType('image')} class="hover:underline">
				<Icon src={Photo} class="w-10 h-10 inline-block" />
				{$t('my.post.image')}
			</button>
			{#if false}
				<button on:click={() => changeType('work')} class="hover:underline">
					<Icon src={Camera} class="w-10 h-10 inline-block" />
					Work(s)
				</button>
			{/if}
		{:else}
			{#if row.type === 'text'}
				<BlogEditText
					on:addBlock
					on:removeBlock
					on:moveUp
					on:moveDown
					bind:value={row.text}
					bind:focus
					{index}
				/>
			{/if}
			{#if row.type === 'image'}
				<BlogEditImage
					on:addBlock
					on:removeBlock
					on:moveUp
					on:moveDown
					image={images.get(row?.image_id.toString())}
					bind:focus
					{index}
				/>
			{/if}
			{#if row.type === 'work'}
				<BlogEditWorks
					on:addBlock
					on:removeBlock
					on:moveUp
					on:moveDown
					bind:value={row.works}
					bind:focus
					{index}
				/>
			{/if}
		{/if}
	</div>
</div>
