<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';

	export let label: string, description: string, error: string;

	// Generate a unique ID for the fields
	const elementId = newUniqueId();
	const descriptionElementId = elementId + '-description';
	const errorElementId = elementId + '-error';
	$: hasError = !!error;
</script>

<div>
	{#if label}
		<label for={elementId} class="block text-sm font-medium leading-6 text-zinc-900">
			{label}
		</label>
	{/if}
	<slot {elementId} {hasError} />
	{#if error}
		<p id={errorElementId} class="mt-2 text-sm text-red-600">
			{error}
		</p>
	{/if}
	{#if description}
		<p id={descriptionElementId} class="mt-2 text-sm text-gray-500">
			{description}
		</p>
	{/if}
</div>
