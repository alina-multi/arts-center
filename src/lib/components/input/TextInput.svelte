<script lang="ts">
	export let id: string, placeholder: string, value: string, error: boolean, name: string;
</script>

<input
	bind:value
	type="text"
	{name}
	{id}
	{placeholder}
	class="block px-6 w-full rounded-full border sm:text-sm dark:bg-zinc-900 dark:border-0 {error
		? 'border-red-300 focus:border-red-300 focus:ring-red-200'
		: 'border-zinc-300 focus:border-sky-500 focus:ring-sky-500'}"
/>
