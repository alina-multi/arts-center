<script lang="ts">
	import '$lib/css/app.css';
	import { darkTheme } from '$lib/stores/dark';
	import MainNav from '$lib/components/nav/MainNav.svelte';
	import { navigating } from '$app/stores';
	import Loader from '$lib/components/atoms/Loader.svelte';

	BigInt.prototype.toJSON = (val) => val.toString();
</script>

<div class="app {$darkTheme ? 'dark bg-black' : 'bg-white'}">
	<MainNav />
	<main class="container mx-auto px-3">
		<slot />
	</main>
</div>
{#if $navigating}
	<div class="absolute inset-0 backdrop-blur-sm bg-white/30 flex justify-center items-center z-50">
		<div class="h-full w-full opacity-50">
			<Loader />
		</div>
	</div>
{/if}
