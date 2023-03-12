<script lang="ts">
	import '$lib/css/app.css';
	import { darkTheme } from '$lib/stores/dark';
	import MainNav from '$lib/components/nav/MainNav.svelte';
	BigInt.prototype.toJSON = (val) => val.toString();
	// So we can use class:dark
</script>

<div class="app {$darkTheme ? 'dark bg-black' : 'bg-white'}">
	<MainNav />
	<main class=" container mx-auto">
		<slot />
	</main>
</div>
