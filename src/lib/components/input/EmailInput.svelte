<script lang="ts">
	export let placeholder: string,
		value: string,
		error: boolean,
		name: string,
		id: string;
</script>

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
