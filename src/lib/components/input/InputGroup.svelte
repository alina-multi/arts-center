<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';

	export let label: string | boolean = false,
		description: string | boolean = false,
		error: string | boolean = false;

	// Generate a unique ID for the fields
	const elementId = newUniqueId();
	const descriptionElementId = elementId + '-description';
	const errorElementId = elementId + '-error';
	let clazz = '';
	export { clazz as class };
	$: hasError = !!error;
</script>

<div class={clazz}>
	{#if label}
		<label for={elementId} class="block text-sm font-semibold mb-1 text-zinc-900 dark:text-white">
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
