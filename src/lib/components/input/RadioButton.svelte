<script lang="ts">
	export let label: string,
		id: string | null,
		name: string | null,
		value: string,
		checked: boolean,
		onChange: (e: Event & { target: HTMLInputElement }) => void;
</script>

<label for={id} class="min-w-0 flex-1 flex gap-3 items-center select-none cursor-pointer">
	<slot />
	{label}
</label>

<input
	{id}
	{name}
	type="radio"
	{value}
	{checked}
	on:change={onChange}
	class="h-5 w-5 border-zinc-300 dark:bg-zinc-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
/>
