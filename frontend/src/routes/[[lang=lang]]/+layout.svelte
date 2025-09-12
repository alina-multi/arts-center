<script lang="ts">
	import '$lib/css/app.css';
	import { navigating, page } from '$app/stores';
	import type { Navigation } from '@sveltejs/kit';
	import { writable } from 'svelte/store';
	import LoaderLayout from '$lib/components/atoms/LoaderLayout.svelte';
	import { browser } from '$app/environment';
	import { onMount, setContext } from 'svelte';
	import loading from '$lib/stores/loading';
	import { switchLocalePath } from '$lib/translations';

	let timer: ReturnType<typeof setTimeout>;
	const navigationIsDelayed = writable(false);

	export let data;
	setContext('t', data.t);
	setContext('locale', data.locale);

	onMount(() => {
		if (browser) {
			const currentLocale = data.locale.get();
			let storedLang = localStorage.getItem('lang');
			if (storedLang && storedLang !== currentLocale) {
				window.location.href = switchLocalePath(
					currentLocale,
					storedLang as 'en' | 'uk',
					$page.url.pathname
				);
			}

			return navigating.subscribe((value: Navigation | null) => {
				if (timer) {
					clearTimeout(timer);
				}
				if (value !== null) {
					timer = setTimeout(() => navigationIsDelayed.set(true), 500);
				} else {
					navigationIsDelayed.set(false);
				}
			});
		}
	});
</script>

<svelte:head>
	<script>
		// Minimal theme initialization to prevent flash of wrong theme
		(function initTheme() {
			if (typeof window === 'undefined') return;
			
			const theme = localStorage.getItem('theme') || 'system';
			
			// Apply theme immediately to prevent flash
			const isDark = theme === 'dark' || 
				(theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
			
			document.documentElement.classList.toggle('dark', isDark);
		})();
	</script>
</svelte:head>

<slot />

{#if $navigationIsDelayed || $loading}
	<LoaderLayout />
{/if}
