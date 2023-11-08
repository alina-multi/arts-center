<script lang="ts">
	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();
	export let id: string,
		placeholder: string ='',
		value: string,
		name: string,
		multiple: boolean = false,
		required: boolean = false,
		accept: string;
</script>

<input
	bind:value
	type="file"
	{name}
	{id}
	{placeholder}
	{accept}
	{multiple}
	{required}
	on:change={(e) => dispatch('change', e.target)}
	class="block  text-sm overflow-hidden text-black border border-gray-300 rounded-sm cursor-pointer w-min dark:bg-zinc-900 dark:text-zinc-400 focus:outline-none dark:border-zinc-600 dark:placeholder-zinc-300"
/>
