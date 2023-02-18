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

	let ariaDescribedBy;
	$: ariaDescribedBy = error ? errorId : descriptionId;
</script>

<div class="flex items-center justify-center bg-white p-8">
	<div class="mx-auto w-full max-w-xs">
		{#if label}
			<label for={id} class="block text-sm font-medium text-zinc-900">
				{label}
			</label>
		{/if}
		<input
			type="email"
			{name}
			{id}
			{placeholder}
			bind:value
			class="block w-full rounded-md border sm:text-sm pr-10 mt-1 {error
				? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200'
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
