<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
</script>

<Toaster />
<MainNav />
<slot />
