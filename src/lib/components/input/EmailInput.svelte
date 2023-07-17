<script lang="ts">
	export let placeholder: string, value: string, error: boolean, name: string, id: string;
</script>

<input
	type="email"
	{name}
	{id}
	{placeholder}
	bind:value
	class="block w-full rounded-full pl-6 border sm:text-sm pr-10 mt-1  dark:bg-zinc-900 {error
		? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200 dark:border-red-500 dark:focus:ring-red-500'
		: 'border-zinc-300 focus:border-sky-200 focus:ring-sky-200 dark:focus:border-sky-700 dark:border-zinc-700 dark:focus:ring-sky-700 '}"
/>
