<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<div
	class=" bg-zinc-100 shadow p-9 dark:bg-zinc-900 dark:border dark:border-zinc-800 max-xl:mt-5 w-full space-y-3 max-lg:px-6"
>
	<p class="text-xl font-semibold">
		{$t('global.not_logged_in.title')}
	</p>
	<div class="dark:text-zinc-100">
		<p>
			{$t('global.not_logged_in.p1')}
		</p>
	</div>

	<div class=" items-center max-lg:justify-cente gap-6 lg:gap-9 pt-3 grid grid-cols-2 font-medium">
		<LoginLink styles=" bg-white border-2 dark:border  " />
		<a
			href={localePath($locale, '/register')}
			class="text-white bg-zinc-900 font-semibold text-center sm:max-lg:w-fit px-3 py-2 border border-zinc-900 dark:border-zinc-500 dark:bg-zinc-800 shadow-sm hover:bg-amber-500 hover:border-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
			>{$t('global.menu.register')}</a
		>
	</div>
</div>
