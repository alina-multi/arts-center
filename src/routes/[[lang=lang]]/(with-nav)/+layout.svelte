<script lang="ts">
	import type { LayoutData } from './$types';
	import MainNav from '$lib/components/nav/MainNav.svelte';
	export let data: LayoutData;
</script>

<MainNav user={data.user} />
<main class="container mx-auto px-3">
	<slot />
</main>
