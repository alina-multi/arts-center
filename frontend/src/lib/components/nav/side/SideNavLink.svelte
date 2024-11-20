<script lang="ts">
	import BaseLink from '$lib/components/nav/BaseLink.svelte';

	export let href;
	export let exact = false;
</script>

<li>
	<BaseLink
		preload="tap"
		{href}
		{exact}
		class=" flex items-center gap-x-3 py-2 px-6  font-medium "
		activeClass="bg-zinc-100 text-black dark:bg-zinc-700 dark:text-white rounded-sm"
		inactiveClass="text-black/80  hover:bg-zinc-100/60 dark:text-white  dark:hover:bg-zinc-700 rounded-sm"
	>
		<slot />
	</BaseLink>
</li>
