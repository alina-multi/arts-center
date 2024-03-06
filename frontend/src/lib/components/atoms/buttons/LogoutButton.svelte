<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Power } from '@steeze-ui/heroicons';
	import { logout } from '$lib/stores/auth';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<button
	on:click={() => logout($locale)}
	class=" flex gap-x-3 py-2 px-6 font-medium text-black/80 hover:bg-gray-50 dark:text-zinc-300 dark:hover:text-white dark:hover:bg-zinc-700 rounded-sm w-full"
	data-sveltekit-preload-data="tap"
	data-sveltekit-reload
>
	<Icon src={Power} theme="solid" class="h-6 w-6 stroke-1" aria-hidden="true" />{$t(
		'global.my_links.logout'
	)}
</button>
