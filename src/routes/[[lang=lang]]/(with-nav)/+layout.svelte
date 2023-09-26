<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
	import { onMount } from 'svelte';
	import type { LayoutData } from './$types';

	export let data: LayoutData;
	let mounted = false;
	onMount(() => (mounted = true));
</script>

{#if mounted}
	<Toaster />
{/if}
{#key data.currentUser?.id}
	<MainNav user={data.currentUser} />
{/key}
<slot />
