<script lang="ts">
	import '$lib/css/app.css';
	import { navigating, page } from '$app/stores';
	import { derived } from 'svelte/store';
	import LoaderLayout from '$lib/components/atoms/LoaderLayout.svelte';
	import { browser } from '$app/environment';
	import { onMount, setContext } from 'svelte';
	import loading from '$lib/stores/loading';
	import { switchLocalePath } from '$lib/translations';

	BigInt.prototype.toJSON = (val) => val.toString();

	let navigationIsDelayed, timer;

	export let data;
	setContext('t', data.t);
	setContext('locale', data.locale);

	onMount(() => {
		if (browser) {
			const currentLocale = data.locale.get();
			let storedLang = localStorage.getItem('lang');
			if (storedLang && storedLang != currentLocale) {
				window.location.href = switchLocalePath(currentLocale, storedLang, $page.url.pathname);
			}

			navigationIsDelayed = derived(navigating, (newValue, set) => {
				if (timer) {
					clearTimeout(timer);
				}
				if (newValue) {
					timer = setTimeout(() => set(true), 500);
				}
				set(false);
			});
		}
	});
</script>

<svelte:head>
	<script>
		let dark = false;

		function onLoad() {
			if (document.body) {
				document.body.classList.add('dark');
			}
		}

		if (typeof window !== 'undefined') {
			const themeStore = localStorage.getItem('dark');

			if (themeStore === null) {
				dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
				localStorage.setItem('dark', JSON.stringify(dark));
			} else {
				dark = JSON.parse(themeStore);
			}

			if (dark) {
				document.documentElement.classList.add('dark');
				window.onload = onLoad;
			}
		}
	</script>
</svelte:head>

<slot />

{#if $navigationIsDelayed || $loading}
	<LoaderLayout />
{/if}
