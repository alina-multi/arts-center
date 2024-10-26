<script lang="ts">
	export let label: string,
		id: string | number,
			name: unknown,
			value: unknown,
		checked: boolean,
		onChange: (e: Event & { target: HTMLInputElement }) => void;
</script>

{#if label}
	<label for={id} class="min-w-0 flex-1 flex gap-3 items-center select-none cursor-pointer">
		<slot />
		{label}
	</label>
{/if}

<input
	{id}
	{name}
	type="radio"
	{value}
	{checked}
	on:change={onChange}
	class="h-5 w-5 border-zinc-300 dark:bg-zinc-300 text-amber-500 focus:ring-amber-500 cursor-pointer"
/>
