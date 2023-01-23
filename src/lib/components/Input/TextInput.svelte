<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';

	export let label: string,
		description: string,
		placeholder: string,
		value: string,
		error: string,
		name: string;

	// Generate a unique ID for the fields
	const id = newUniqueId();
	const descriptionId = id + '-description';
	const errorId = id + '-error';
</script>

<div class="flex items-center justify-center bg-white p-8">
	<div class="mx-auto w-full max-w-xs">
		{#if label}
			<label for={id} class="block text-sm font-medium text-zinc-700 mb-1"> {label}</label>
		{/if}
		<input
			bind:value={value}
			type="text"
			{name}
			{id}
			{placeholder}
			class="block w-full rounded-md border sm:text-sm {error
				? 'border-red-300 focus:border-red-300 focus:ring-red-200'
				: 'border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200'}"
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
</div>
