<script lang="ts">
	import BaseLink from '$lib/components/nav/BaseLink.svelte';

	export let href;
</script>

<li>
	<BaseLink
		{href}
		class=" flex gap-x-3 py-2 px-6 text-sm leading-6 font-semibold "
		activeClass="bg-gray-100 text-gray-900/70 dark:bg-zinc-700 dark:text-white rounded-sm"
		inactiveClass="text-gray-700  hover:bg-gray-50 dark:text-zinc-300 dark:hover:text-white dark:hover:bg-zinc-700 rounded-sm"
	>
		<slot />
	</BaseLink>
</li>
