<script lang='ts'>
	export let id: string,
		placeholder: string = '',
		value: string,
		error: boolean = false,
		name: string,
		disabled = false;

</script>
<div
	class=" flex rounded-sm shadow-sm  ring-1 dark:ring-zinc-700 ring-inset focus-within:ring-2 focus-within:ring-inset dark:bg-zinc-900    {error
		? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200 dark:border-red-500 dark:focus:ring-red-500'
		: 'ring-gray-300 focus-within:ring-blue-500 text-gray-500 dark:text-zinc-300'}"
>
				<span class='flex select-none items-center pl-3 sm:text-sm'><slot /></span
				>
	<input
		bind:value
		type='text'
		{name}
		{id}
		{placeholder}
		{disabled}
		on:focus={() => (error = false)}
		class='block flex-1 border-0 bg-transparent py-1.5 pl-1 text-black dark:text-zinc-100 focus:ring-0 sm:text-sm sm:leading-6'
	/>
</div>