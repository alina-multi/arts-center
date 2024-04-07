<script lang="ts">
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let primary: boolean = false;

	$: redirect = $page.url.pathname.length > 1 ? `?redirect=${$page.url.pathname}` : '';
</script>

<a
	href={localePath($locale, `/login${redirect}`)}
	class="  {primary
		? 'w-full  bg-amber-600 text-white text-lg font-semibold  hover:bg-amber-500 px-3 py-1.5'
		: ' border border-black text-black text-sm  dark:text-white dark:border-zinc-500 dark:bg-zinc-800  hover:bg-zinc-100 dark:hover:bg-zinc-900  px-3 py-2'} text-center "
	>{$t('global.buttons.login').toUpperCase()}</a
>
