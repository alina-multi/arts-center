<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<div
	class=" dark:p-6 dark:bg-zinc-900 dark:border dark:border-zinc-800 max-lg:text-cente max-xl:mt-5 w-full space-y-3 max-lg:px-3"
>
	<p class="text-xl text-emerald-700 font-semibold dark:text-emerald-500">
		{$t('global.not_logged_in.title')}
	</p>
	<div class="dark:text-zinc-100">
		<p class="max-md:dark:hidden">
			{$t('global.not_logged_in.p1')}
		</p>
		<p class=" max-sm:hidden">
			{$t('global.not_logged_in.p2')}
		</p>
	</div>

	<div class=" items-center max-lg:justify-cente gap-6 pt-3 grid grid-cols-2 sm:w-1/2 font-medium">
		<LoginLink />
		<a
			href={localePath($locale, '/register')}
			class=" text-center sm:max-lg:w-fit text-sm px-3 py-2 border border-zinc-900 dark:border-zinc-500 dark:bg-zinc-800 shadow-sm hover:bg-amber-500 hover:border-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
			>{$t('global.menu.register')}</a
		>
	</div>
</div>
