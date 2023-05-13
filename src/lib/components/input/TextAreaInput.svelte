<script lang="ts">
	export let id: string, placeholder: string, value: string, error: boolean, name: string;
</script>

<textarea
	{id}
	{placeholder}
	{name}
	bind:value
	rows="3"
	class="block w-full text-gray-900 placeholder:text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:placeholder:text-gray-300 dark:focus:border-sky-700 dark:focus:ring-sky-700 shadow-sm focus:border-sky-600/50 focus:ring-sky-600/50 {error
		? 'border-red-300 focus:border-red-300 focus:ring-red-200'
		: 'border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200'}"
/>
