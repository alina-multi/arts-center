<script lang='ts'>
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
	import type { LayoutData } from './$types';
	import { browser } from '$app/environment';
	import { checkAuth } from '$lib/stores/auth';

	export let data: LayoutData;
	if (browser) {
		checkAuth()
	}
</script>
{#if browser}
	<Toaster />
{/if}
<MainNav />
<slot />
