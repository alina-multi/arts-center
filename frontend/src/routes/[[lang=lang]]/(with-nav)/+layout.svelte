<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
	import { browser } from '$app/environment';
	import { checkAuth } from '$lib/stores/auth';
	import NotificationToasts from '$lib/components/notification/NotificationToasts.svelte';
	import { page } from '$app/stores';

	import AuthModal from '$lib/components/atoms/AuthModal.svelte';

	export let data;

	if (browser) {
		window.__DEMO__ = Boolean(data.demo);
		checkAuth();
	}
</script>

{#if browser}
	<Toaster />
	<NotificationToasts />
{/if}
<MainNav />
<slot />

{#if !$page.state?.workModal && $page.route.id !== '/[[lang=lang]]/(with-nav)/(single-column)/work/[id=int]'}
	<AuthModal />
{/if}
