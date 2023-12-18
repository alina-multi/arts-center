<script lang='ts'>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { PlusCircle, Photo, Camera } from '@steeze-ui/heroicons';
	import BlogEditText from '$lib/components/input/BlogEditText.svelte';
	import BlogEditImage from '$lib/components/input/BlogEditImage.svelte';
	import BlogEditWorks from '$lib/components/input/BlogEditWorks.svelte';
	import {createEventDispatcher} from 'svelte';
	const dispatch = createEventDispatcher();

	export let row;
	export let index:number, focus:number|undefined;

	let displayPlus = true;
	let displayTypeButtons = false;
	$:displayPlus = row.type === 'text' && row.text === '';

	function toggleTypeButtons() {
		displayTypeButtons = !displayTypeButtons;
	}

	function changeType(newType) {
		displayTypeButtons = false;
		if(newType === 'image'){
			dispatch('uploadImage');
		}
		if(newType === 'work'){
			dispatch('attachWorks');
		}
	}
</script>
<div class='flex group h-10 border-dashed border-1 border-zinc-100'>
	<div class='w-16'>
		{#if displayPlus}
			<button class:rotate-45={displayTypeButtons} on:click={toggleTypeButtons}>
				<Icon src={PlusCircle} class='w-12 h-12 text-gray-500' />
			</button>
		{/if}
	</div>
	<div class='grow'>
		{#if displayTypeButtons}
			<button on:click={()=>changeType('image')} class='hover:underline'>
				<Icon src={Photo} class='w-10 h-10 inline-block' />
				Image
			</button>
			<button on:click={()=>changeType('work')} class='hover:underline'>
				<Icon src={Camera} class='w-10 h-10 inline-block' />
				Work(s)
			</button>
		{:else}
			{#if row.type === 'text'}
				<BlogEditText on:addBlock on:removeBlock on:moveUp on:moveDown bind:value={row.text} bind:focus {index} />
			{/if}
			{#if row.type === 'image'}
				<BlogEditImage on:addBlock on:removeBlock on:moveUp on:moveDown image={row.image} bind:focus {index} />
			{/if}
			{#if row.type === 'work'}
				<BlogEditWorks on:addBlock on:removeBlock on:moveUp on:moveDown bind:value={row.works} bind:focus {index} />
			{/if}
		{/if}
	</div>
</div>