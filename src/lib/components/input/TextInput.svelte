<script lang="ts">
	export let id: string, placeholder: string = '', value: string, error: boolean = false, name: string;
</script>

<input
	bind:value
	type="text"
	{name}
	{id}
	{placeholder}
	class="block px-3 w-full rounded-sm border sm:text-sm dark:bg-zinc-900 dark:border-0 {error
		? 'border-red-300 focus:border-red-300 focus:ring-red-200'
		: 'border-zinc-300 focus:border-blue-500 focus:ring-blue-500'}"
/>
