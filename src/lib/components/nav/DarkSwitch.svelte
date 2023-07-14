<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Moon, Sun } from '@steeze-ui/heroicons';

	let dark = null;
	if (typeof window !== 'undefined') {
		dark = JSON.parse(localStorage.getItem('dark'));
	}

	const toggleDark = () => {
		dark = !dark;
		document.querySelector('body')?.classList.toggle('dark');
		document.documentElement.classList.toggle('dark');
		localStorage.setItem('dark', JSON.stringify(dark));
	};
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->

<div
	class=" md:max-xl:ml-6 ml-3 h-full cursor-pointer text-sm inline-flex items-center bg-gray-100 dark:bg-gray-700 p-3 hover:bg-gray-200 dark:hover:bg-gray-600"
	on:click={toggleDark}
>
	{#if dark === null}
		<Icon src={Moon} theme="solid" class="text-amber-800 h-6 w-6  animate-spin" />
	{/if}
	{#if dark === true}
		<Icon src={Sun} theme="solid" class="text-amber-300 h-6 w-6 " />
	{/if}
	{#if dark === false}
		<Icon src={Moon} theme="solid" class="text-amber-800 h-6 w-6 " />
	{/if}
</div>
