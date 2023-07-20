<script lang="ts">
	import { createEventDispatcher } from 'svelte';
	const dispatch = createEventDispatcher();
	export let id: string,
		placeholder: string,
		value: string,
		error: boolean,
		name: string,
		multiple: boolean,
		required: boolean,
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
	class="block w-full text-sm overflow-hidden text-gray-900 border border-gray-300 rounded-full cursor-pointer bg-gray-50 dark:bg-zinc-900 dark:text-zinc-400 focus:outline-none dark:border-zinc-600 dark:placeholder-zinc-300"
/>
