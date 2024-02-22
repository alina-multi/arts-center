<script lang="ts">
	import { getContext } from 'svelte';
	import LoginLink from '../nav/LoginLink.svelte';
	import { localePath } from '$lib/translations';

	const t = getContext('t');
	const locale = getContext('locale');
</script>

<div
	class="flex flex-col gap-6 max-lg:items-center border-b dark:border-zinc-900 pb-6 xs:max-lg:px-6"
>
	<p class="text-lg font-semibold dark:text-zinc-100">
		{$t('global.not_logged_in.for_comment')}
	</p>

	<p class=" text-gray-500 dark:text-zinc-400 lg:text-sm md:max-lg:w-2/3 max-lg:text-center">
		{$t('global.not_logged_in.for_work')}
	</p>

	<div class="flex items-center gap-6">
		<LoginLink />
		<a
			href={localePath($locale, '/register')}
			class=" text-center sm:max-lg:w-fit rounded-sm px-3 py-0.5 border border-zinc-600 shadow-sm hover:bg-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
			>{$t('global.buttons.register')}</a
		>
	</div>

	<!-- <a
		href="/login"
		class="max-sm:w-full lg:w-full text-center sm:max-lg:w-fit rounded-sm px-6 py-1 text-white bg-amber-600 shadow-sm hover:bg-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
		>{$t('global.not_logged_in.sign_in_with_email')}</a
	> -->
</div>
