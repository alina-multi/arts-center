<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<div
	class=" dark:p-6 dark:bg-zinc-900 dark:border dark:border-zinc-800 max-lg:text-center max-xl:mt-6 w-full space-y-3"
>
	<p class="text-xl font-serif text-emerald-700 font-semibold dark:text-emerald-600">
		{$t('global.not_logged_in.title')}
	</p>
	<div>
		<p class="max-md:dark:hidden dark:text-zinc-400">
			{$t('global.not_logged_in.p1')}
		</p>
		<p class=" max-sm:hidden dark:text-zinc-400">
			{$t('global.not_logged_in.p2')}
		</p>
	</div>

	<div class="flex items-center max-lg:justify-center gap-6 pt-3">
		<LoginLink />
		<a
			href={localePath($locale, '/register')}
			class=" text-center sm:max-lg:w-fit text-sm px-3 py-2 border border-zinc-600 shadow-sm hover:bg-amber-500 hover:border-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
			>{$t('global.menu.register')}</a
		>
	</div>
</div>
