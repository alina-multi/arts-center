<script lang="ts">
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
	export let styles =
		'border-zinc-800 bg-white  shadow-sm hover:text-white font-medium dark:border-zinc-500';
</script>

<a
	href={localePath($locale, '/register')}
	class=" {styles}  text-center px-4 py-2 block border cursor-pointer hover:border-amber-500 hover:bg-amber-500 dark:hover:bg-amber-600 dark:hover:border-amber-600 dark:text-white dark:bg-zinc-800"
	>{$t('global.menu.register')}</a
>
