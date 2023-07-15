<script lang="ts">
	import '$lib/css/app.css';
	import { navigating } from '$app/stores';
	import Loader from '$lib/components/atoms/Loader.svelte';
	import { derived } from 'svelte/store';

	BigInt.prototype.toJSON = (val) => val.toString();

	let timer = null;
	const navigationIsDelayed = derived(navigating, (newValue, set) => {
		if (timer) {
			clearTimeout(timer);
		}
		if (newValue) {
			timer = setTimeout(() => set(true), 500);
		}
		set(false);
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

{#if $navigationIsDelayed}
	<div class="absolute inset-0 backdrop-blur-sm bg-white/30 flex justify-center items-center z-50">
		<div class="h-full w-full opacity-50">
			<Loader />
		</div>
	</div>
{/if}
