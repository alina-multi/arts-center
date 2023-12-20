<script lang="ts">
	import { getContext } from 'svelte';

	const t = getContext('t');
</script>

<div class="flex flex-col gap-3 border p-3 sm:p-6 rounded-sm dark:border-zinc-800 dark:bg-zinc-900">
	<p class="lg:text-lg font-semibold dark:text-zinc-100">
		{$t('global.not_logged_in.for_comment')}
	</p>
	<p class=" text-gray-500 dark:text-zinc-400 text-sm">
		{$t('global.not_logged_in.for_work')}
	</p>

	<a
		href="/login"
		class="max-sm:w-full lg:w-full text-center sm:max-lg:w-fit rounded-sm px-6 py-1 text-white bg-amber-600 shadow-sm hover:bg-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
		>{$t('global.not_logged_in.sign_in_with_email')}</a
	>
</div>
