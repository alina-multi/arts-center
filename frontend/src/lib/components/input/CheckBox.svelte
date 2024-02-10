<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';
	export let name: string;

	let id = newUniqueId();
</script>

<div class="flex items-center">
	<input
		{id}
		{name}
		type="checkbox"
		class="h-4 w-4 rounded border-gray-300 dark:border-zinc-500 text-blue-600 focus:ring-blue-600 cursor-pointer dark:bg-zinc-600"
	/>
	<label for={id} class="ml-2 block text-sm text-black dark:text-white cursor-pointer">
		<slot />
	</label>
</div>
