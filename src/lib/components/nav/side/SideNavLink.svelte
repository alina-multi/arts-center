<script lang="ts">
	import BaseLink from '$lib/components/nav/BaseLink.svelte';

	export let href;
	export let exact = false;
</script>

<li>
	<BaseLink
		{href}
		{exact}
		class=" flex items-center gap-x-3 py-2 px-6  font-semibold "
		activeClass="bg-zinc-100 text-zinc-900/70 dark:bg-zinc-700 dark:text-white rounded-sm"
		inactiveClass="text-gray-700  hover:bg-zinc-100 dark:text-zinc-300 dark:hover:text-white dark:hover:bg-zinc-700 rounded-sm"
	>
		<slot />
	</BaseLink>
</li>
