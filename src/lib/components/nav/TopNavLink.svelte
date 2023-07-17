<script lang="ts">
	import { page } from '$app/stores';

	export let href: string;
	export let exact = false;
	export let active: boolean | undefined;
	export let reload = false;
	export let preload = 'hover';
	export let media = 'desktop';
	let style;
	let activeLink;

	let styleDesktop = 'border-b-2 px-1 pt-1';
	let styleMobile = 'border-l-2 px-3 py-2 ';
	let activeLinkMobile = 'bg-gray-100 dark:bg-zinc-800';
	let inactiveLink =
		'border-transparent hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300';

	if (media === 'desktop') {
		style = styleDesktop;
	}
	if (media === 'mobile') {
		style = styleMobile;
		activeLink = activeLinkMobile;
	}

	function isActive(exact, pathname, active): boolean {
		if (active !== undefined) return active;
		if (exact) return pathname === href;
		return pathname.startsWith(href);
	}
	$: computedActive = isActive(exact, $page.url.pathname, active);
</script>

<a
	{href}
	class="inline-flex h-full items-center text-lg  border-amber-500 {style}
        {computedActive ? activeLink : inactiveLink} "
	data-sveltekit-reload={reload ? '' : 'off'}
	data-sveltekit-preload-data={preload}
>
	<slot />
</a>
