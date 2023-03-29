<script lang="ts">
	import '$lib/css/app.css';
	import { darkTheme } from '$lib/stores/dark';
	import MainNav from '$lib/components/nav/MainNav.svelte';
	import { navigating } from "$app/stores";
	BigInt.prototype.toJSON = (val) => val.toString();
</script>

<div class="app {$darkTheme ? 'dark bg-black' : 'bg-white'}">
	<MainNav />
	<main class="container mx-auto">
		<slot />
	</main>
</div>
{#if $navigating}
	<div class="absolute inset-0 backdrop-blur-sm bg-white/30 flex justify-center items-center z-50">
		<div>Spinner will be here...</div>
	</div>
{/if}
