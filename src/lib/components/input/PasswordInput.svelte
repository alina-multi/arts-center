<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Eye, EyeSlash } from '@steeze-ui/heroicons';

	export let label: string,
		description: string,
		placeholder: string,
		value: string,
		error: string,
		name: string;
	let type = 'password';

	// Generate a unique ID for the fields
	const id = newUniqueId();
	const descriptionId = id + '-description';
	const errorId = id + '-error';

	let ariaDescribedBy;
	$: ariaDescribedBy = error ? errorId : descriptionId;

	let show_password = false;
	$: type = show_password ? 'text' : 'password';
</script>

<div class="flex items-center justify-center bg-white">
	<div class="mx-auto w-full max-w-xs">
		{#if label}
			<label for={id} class="block text-sm font-medium text-zinc-900 mb-1">
				{label}
			</label>
		{/if}
		<div class="relative">
			<input
				{name}
				{id}
				{type}
				{placeholder}
				{value}
				on:input={(e) => (value = e.target.value)}
				class="block w-full rounded-md border sm:text-sm pr-10 {error
					? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200'
					: 'border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200'}"
			/>
			<a
				class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer"
				on:click={() => (show_password = !show_password)}
			>
				{#if show_password}
					<Icon src={Eye} class="h-6 text-gray-700" />
				{:else}
					<Icon src={EyeSlash} class="h-6 text-gray-700" />
				{/if}
			</a>
		</div>
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
