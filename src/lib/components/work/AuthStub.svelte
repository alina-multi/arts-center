<script lang="ts">
	import Divider from '$lib/components/atoms/Divider.svelte';
	import SocialMediaButtons from '$lib/components/atoms/buttons/SocialMediaButtons.svelte';
	import { t } from '$lib/translations';
</script>

<div class="flex flex-col gap-3 border p-6 rounded-sm dark:border-zinc-800 dark:bg-zinc-900">
	<p class="text-lg leading-4 font-semibold xl:text-center dark:text-zinc-100">
		{$t('global.not_logged_in.for_comment')}
	</p>
	<p class=" text-gray-500 dark:text-zinc-400 text-sm xl:text-center">
		{$t('global.not_logged_in.for_work')}
	</p>

	<div
		class="flex flex-col sm:max-lg:flex-row sm:max-lg:items-center md:max-lg:gap-9 max-md:justify-between"
	>
		<div class="flex max-sm:w-full justify-center items-center">
			<a
				href="/login"
				class="xl:max-w-fit max-sm:w-full lg:w-full text-center rounded-full px-6 py-1 text-white bg-amber-600 shadow-sm hover:bg-amber-500 dark:text-gray-100 hover:text-white cursor-pointer"
				>{$t('global.not_logged_in.sign_in_with_email')}</a
			>
		</div>

		<Divider>{$t('global.common.continue_with')}</Divider>

		<SocialMediaButtons />
	</div>
</div>
