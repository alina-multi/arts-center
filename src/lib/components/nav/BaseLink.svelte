<script lang="ts">
	import { page } from '$app/stores';

	export let href: string;
	export let exact = false;
	export let reload = false;
	export let preload = 'hover';
	export let active: boolean;
	export let activeClass = '';
	export let inactiveClass = '';
	let clazz;
	export { clazz as class };

	function isActive(exact, pathname, active): boolean {
		if (active !== undefined) return active;
		if (exact) return pathname === href;
		return pathname.startsWith(href);
	}

	$: computedActive = isActive(exact, $page.url.pathname, active) ? activeClass : inactiveClass;
</script>

<a
	{href}
	class="{clazz} {computedActive}"
	data-sveltekit-reload={reload ? '' : 'off'}
	data-sveltekit-preload-data={preload}
>
	<slot />
</a>
