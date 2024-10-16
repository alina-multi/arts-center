<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<div
	class=" dark:xl:p-9    dark:bg-zinc-900 dark:border dark:border-zinc-800 max-xl:mt-5 w-full space-y-3 max-sm:pt-9 dark:p-6"
>
	<p class="text-2xl font-semibold">
		{$t('global.not_logged_in.title')}
	</p>
	<div class="dark:text-zinc-100">
		<p>
			{$t('global.not_logged_in.p1')}
		</p>
	</div>

	<div class="   gap-6  pt-3 grid grid-cols-2 font-medium">
		<LoginLink styles=" bg-white border dark:border  " />
		<a
			href={localePath($locale, '/register')}
			class="font-medium  text-center  px-4 py-2 rounded-full block border border-zinc-800 bg-white  dark:border-zinc-500 dark:bg-zinc-800 shadow-sm hover:bg-amber-500 hover:border-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
			>{$t('global.menu.register')}</a
		>
	</div>
</div>
