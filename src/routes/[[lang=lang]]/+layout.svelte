<script lang="ts">
	import '$lib/css/app.css';
	import { darkTheme } from '$lib/stores/dark';
	import { navigating } from '$app/stores';
	import Loader from '$lib/components/atoms/Loader.svelte';

	BigInt.prototype.toJSON = (val) => val.toString();
</script>

<div class="app {$darkTheme ? 'dark bg-black' : 'bg-white'}">
	<slot />
</div>
{#if $navigating}
	<div class="absolute inset-0 backdrop-blur-sm bg-white/30 flex justify-center items-center z-50">
		<div class="h-full w-full opacity-50">
			<Loader />
		</div>
	</div>
{/if}
