<script lang="ts">
	import BaseLink from '$lib/components/nav/BaseLink.svelte';

	export let href: string;
	export let exact = false;
	export let active: boolean | undefined;
	export let reload = false;
	export let preload = 'hover';
	export let media = 'desktop';
	let style;

	let styleDesktop = 'border-b-2 px-1 pt-1';
	let styleMobile = 'border-l-2 px-3 py-1 ';

	if (media === 'desktop') {
		style = styleDesktop;
	}
	if (media === 'mobile') {
		style = styleMobile;
	}
</script>

<BaseLink
	{href}
	{reload}
	{preload}
	{exact}
	{active}
	class="inline-flex h-full items-center text-lg border-amber-500 {style}"
	inactiveClass="border-transparent hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300"
>
	<slot />
</BaseLink>
