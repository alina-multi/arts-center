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

<slot />

{#if $navigationIsDelayed}
	<div class="absolute inset-0 backdrop-blur-sm bg-white/30 flex justify-center items-center z-50">
		<div class="h-full w-full opacity-50">
			<Loader />
		</div>
	</div>
{/if}
