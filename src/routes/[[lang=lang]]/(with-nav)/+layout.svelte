<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
</script>

<Toaster />
<MainNav />
<main class="container mx-auto px-3 min-h-screen">
	<slot />
</main>
