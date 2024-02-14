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
	export let tabindex: number, focus: number | undefined;

	let t = getContext('t');
	let displayTypeButtons = false;

	$: displayPlus = row.type === 'text' && ['<br>', ''].includes(row.text);
	$: isFocused = tabindex === focus;
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

<div class="flex group {isFocused ? ' ring-0 ring-transparent' : 'ring-transparent'}">
	<div class="md:w-16 w-9">
		{#if displayPlus}
			<button class:rotate-45={displayTypeButtons} on:click={toggleTypeButtons}>
				<Icon src={PlusCircle} class="w-8 h-8 xs:w-10 xs:h-10 stroke-[0.7] mt-1" />
			</button>
		{/if}
		{#if displayRowActions}
			<button on:click={removeBlock}>
				<Icon src={Trash} class="w-6 h-6 text-red-300 stroke-1 " />
			</button>
		{/if}
	</div>
	<div class="w-full">
		{#if displayTypeButtons}
			<button on:click={() => changeType('image')} class="hover:underline">
				<Icon src={Photo} class="w-10 h-10 inline-block stroke-1 mt-1" />
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
					{tabindex}
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
					{tabindex}
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
					{tabindex}
				/>
			{/if}
		{/if}
	</div>
</div>
