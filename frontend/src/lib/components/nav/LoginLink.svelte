<script lang="ts">
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';
	import { getContext } from 'svelte';
	import { showAuthModal } from '$lib/stores/auth';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	const t = getContext('t');
	const locale = getContext('locale');
	export let styles = 'text-sm';

	function onClick() {
		showAuthModal.set(true);
		dispatch('login-click');
	}

	

	$: redirect = $page.url.pathname.length > 1 ? `?redirect=${$page.url.pathname}` : '';
</script>

<a
	href={localePath($locale, `/login${redirect}`)}
	on:click|preventDefault={onClick}
	class=" {styles}  border border-black text-black dark:text-white dark:border-zinc-500 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-900 px-4 py-2 text-center"
	>{$t('global.login.sign_in').toUpperCase()}</a
>
