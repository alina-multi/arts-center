<script lang="ts">
	export let id: string,
		placeholder: string,
		value: string,
		error: boolean,
		name: string;

</script>
	<input
		bind:value
		type="text"
		{name}
		{id}
		{placeholder}
		class="block w-full rounded-md border sm:text-sm {error
			? 'border-red-300 focus:border-red-300 focus:ring-red-200'
			: 'border-zinc-300 focus:border-indigo-300 focus:ring-indigo-200'}"
	/>