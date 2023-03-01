<script lang="ts">
	import { page } from '$app/stores';

	export let href: string;
	export let exact = false;
	export let active: boolean | undefined;
	export let reload = false;
	export let preload = 'hover';

	function isActive(exact, pathname, active): boolean {
		if (active !== undefined) return active;
		if (exact) return pathname === href;
		return pathname.startsWith(href);
	}
	$: computedActive = isActive(exact, $page.url.pathname, active);
</script>

<a
        {href}
        class="inline-flex items-center border-b-2 px-1 pt-1 text-lg font-medium 
        { computedActive ? 'border-amber-500'
        : 'border-transparent hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300'
        }"
        data-sveltekit-reload="{reload ? '' : 'off'}"
        data-sveltekit-preload-data="{preload}"
>
	<slot />
</a>
