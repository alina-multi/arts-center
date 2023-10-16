<script lang="ts">
	export let id: string,
		placeholder: string = '',
		value: string,
		error: boolean = false,
		name: string;

	let clazz;
	export { clazz as class };
</script>

<input
	bind:value
	type="text"
	{name}
	{id}
	{placeholder}
	on:focus={() => (error = false)}
	class="block w-full rounded-sm pl-3 border sm:text-sm pr-10 mt-1 dark:bg-zinc-900 {clazz} {error
		? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200 dark:border-red-500 dark:focus:ring-red-500'
		: 'border-zinc-300 focus:border-blue-200 focus:ring-blue-200 dark:focus:border-blue-700 dark:border-zinc-700 dark:focus:ring-blue-700 '}"
/>
