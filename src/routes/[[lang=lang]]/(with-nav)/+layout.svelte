<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
	import { onMount } from 'svelte';

	let mounted = false;
	onMount(() => (mounted = true));
</script>

{#if mounted}
	<Toaster />
{/if}
<MainNav />
<slot />
