<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
	import { browser } from '$app/environment';
	import { checkAuth } from '$lib/stores/auth';
	import NotificationToasts from '$lib/components/notification/NotificationToasts.svelte';

	import AuthModal from '$lib/components/atoms/AuthModal.svelte';

	if (browser) {
		checkAuth();
	}
</script>

{#if browser}
	<Toaster />
	<NotificationToasts />
{/if}
<MainNav />
<slot />

<AuthModal />
