<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Eye, EyeSlash } from '@steeze-ui/heroicons';

	export let id: string , value: string , error: boolean = false, name: string, autocomplete: string;
	let type = 'password';

	let show_password = false;
	$: type = show_password ? 'text' : 'password';
	$: inputAttrs = {
		name,
		id,
		type,
		autocomplete,
		value
	};
</script>

<div class="relative">
	<input
		{...inputAttrs}
		on:input={(e) => (value = e.target.value)}
		class=" block w-full rounded-sm pl-3 border sm:text-sm pr-10 dark:bg-zinc-900 {error
			? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200  dark:border-red-500 dark:focus:ring-red-500 '
			: 'border-zinc-300 focus:border-blue-200 focus:ring-blue-200 dark:focus:border-blue-700 dark:border-zinc-700 dark:focus:ring-blue-700 '}"
	/>

	<button
		class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer"
		on:click|preventDefault={() => (show_password = !show_password)}
	>
		<Icon src={show_password ? Eye : EyeSlash} class="h-6 w-6 text-gray-700 dark:text-zinc-500 " />
	</button>
</div>
