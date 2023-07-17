<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Eye, EyeSlash } from '@steeze-ui/heroicons';

	export let id: string, value: string, error: boolean, name: string, autocomplete: string;
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
		class=" block w-full rounded-md border sm:text-sm pr-10 dark:bg-zinc-800 {error
			? 'text-red-600 border-red-300 focus:border-red-300 focus:ring-red-200  dark:border-red-500 dark:focus:ring-red-500'
			: 'border-zinc-300 focus:border-sky-200 focus:ring-sky-200 dark:focus:border-sky-700 dark:border-zinc-700 dark:focus:ring-sky-700 '}"
	/>

	<button
		class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer"
		on:click|preventDefault={() => (show_password = !show_password)}
	>
		<Icon src={show_password ? Eye : EyeSlash} class="h-6 w-6 text-gray-700 dark:text-zinc-500 " />
	</button>
</div>
