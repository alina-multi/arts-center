<script>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Moon, Sun } from '@steeze-ui/heroicons';
	import { darkTheme } from '$lib/stores/dark';

	const toggleDark = () => ($darkTheme = !$darkTheme);
</script>

<div class="cursor-pointer text-sm inline-flex items-center bg-gray-100 dark:bg-gray-700 p-3 hover:bg-gray-200 dark:hover:bg-gray-600" on:click={toggleDark}>
    {#if $darkTheme}
        <Icon src={Sun} theme="solid" class="text-amber-300 h-6 w-6"/>
    {:else}
        <Icon src={Moon} theme="solid" class="text-amber-800 h-6 w-6"/>
    {/if}
</div>
