<script lang="ts">
	import MainNav from '$lib/components/nav/top/MainNav.svelte';
	import { Toaster } from 'svelte-french-toast';
	import { browser } from '$app/environment';
	import { checkAuth } from '$lib/stores/auth';
	import NotificationToasts from '$lib/components/notification/NotificationToasts.svelte';
	import { page } from '$app/stores';
	import EzoicAd from '$lib/components/ads/EzoicAd.svelte';

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
<div class="flex items-center justify-center">
<!-- Enable reserved space once site is approved <div class="h-[66px] md:h-[106px] flex items-center justify-center">-->
	<EzoicAd placeholderId={101} />
</div>
<slot />

{#if !$page.state?.workModal && $page.route.id !== '/[[lang=lang]]/(with-nav)/(single-column)/work/[id=int]'}
	<AuthModal />
{/if}
