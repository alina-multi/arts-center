<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';

	export let label: string | boolean = false,
		description: string | boolean = false,
		placeholder: string = '',
		value: string,
		error: string | boolean = false,
		name: string,
		rows = 3,
		id = newUniqueId();

	// Generate a unique ID for the fields

	const descriptionId = id + '-description';
	const errorId = id + '-error';
</script>

<div class="mx-auto w-full">
	{#if label}
		<label for={id} class="block text-sm font-medium text-gray-700">
			{label}
		</label>
	{/if}
	<textarea
		on:focus={() => (error = false)}
		{id}
		{placeholder}
		{name}
		bind:value
		{rows}
		class="block w-full text-black placeholder:text-sm rounded-sm border-gray-300 dark:border-zinc-900 dark:bg-zinc-900 dark:text-zinc-300 dark:placeholder:text-zinc-300 dark:focus:border-zinc-700 dark:focus:ring-zinc-700 shadow-sm focus:border-zinc-600 focus:ring-zinc-600/50 {error
			? 'border-red-300 focus:border-red-300 focus:ring-red-200'
			: 'border-zinc-300 focus:border-blue-300 focus:ring-blue-200'}"
	/>
	{#if error}
		<p id={errorId} class="mt-2 text-sm text-red-600">
			{error}
		</p>
	{/if}
	{#if description}
		<p id={descriptionId} class="mt-2 text-sm text-gray-500">
			{description}
		</p>
	{/if}
</div>
