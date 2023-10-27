<script lang="ts">
	import { localePath } from '$lib/translations';
	import { page } from '$app/stores';
	import { t } from '$lib/translations';
	export let primary: boolean = false;

	$: redirect = $page.url.pathname.length > 1 ? `?redirect=${$page.url.pathname}` : '';
</script>

<a
	href={localePath(`/login${redirect}`)}
	class="  rounded-sm {primary
		? 'w-full text-center bg-amber-600 text-white text-lg font-semibold  hover:bg-amber-500 px-3 py-1.5'
		: ' border border-black text-black text-sm  dark:text-white dark:border-zinc-500 dark:bg-zinc-800  hover:border-amber-600 hover:text-amber-600 dark:hover:bg-zinc-900 dark:hover:text-amber-500 dark:hover:border-amber-500 px-3 py-1'}  hover:shadow-xl shadow-md"
	>{$t('global.buttons.login').toUpperCase()}</a
>
