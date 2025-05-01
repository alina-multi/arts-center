<script lang="ts">
	import { user } from '$lib/stores/auth';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';
	import { page } from '$app/stores';
	import SelectLang from '$lib/components/filters/SelectLang.svelte';
	import BlockedUsersPage from '$lib/components/my/BlockedUsersPage.svelte';
	import BeforeNavigateLayout from '$lib/components/atoms/BeforeNavigateLayout.svelte';
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChevronRight } from '@steeze-ui/heroicons';

	$: redirect = $page.url.pathname.length > 1 ? `?redirect=${$page.url.pathname}` : '';

	const t = getContext('t');
	const locale = getContext('locale');
	console.log($user);
</script>

<div class="bg-zinc-100 dark:bg-zinc-900 md:p-12 rounded-md">
	<div
		class="space-y-6 sm:space-y-9 divide-y border dark:divide-zinc-600 dark:border-zinc-600 rounded-md font-medium bg-white dark:bg-zinc-800 lg:w-3/4 mx-auto"
	>
		<div
			class="  flex gap-6 xs:items-center flex-col xs:flex-row xs:justify-between pt-6 px-6 sm:pt-9 sm:px-9"
		>
			<span>{$t(`my.settings.my_intent`)}</span>

			<a
				href={localePath($locale, `/intent${redirect}`)}
				class=" pl-4 gap-6 flex items-center border dark:border-0 dark:bg-zinc-900 rounded-xl text-sm overflow-hidden justify-between"
			>
				<span
					>{$user.intent
						? $t(`global.intent.${$user.intent}.title`)
						: $t(`my.settings.no_chosen`)}</span
				>
				<span
					class="bg-zinc-700 hover:bg-zinc-700/80 dark:hover:bg-zinc-700 dark:bg-zinc-600 text-white py-2 px-6"
				>
					{$t(`my.settings.change`)}
				</span>
			</a>
		</div>

		<div
			class=" flex gap-6 xs:items-center flex-col xs:flex-row xs:justify-between pt-6 px-6 sm:pt-9 sm:px-9"
		>
			{$t('my.blocked')}: {$user.blacklists.length}
			<a
				href={localePath($locale, `/my/blacklist`)}
				class="flex font-medium max-xs:text-sm items-center gap-1 hover:underline hover:text-zinc-900/70 py-1 rounded-xl max-xs:bg-zinc-100 max-xs:px-6 max-xs:py-2 max-xs:justify-between"
			>
				{$t(`my.settings.see_all`)}
				<Icon src={ChevronRight} class="h-6 w-6" />
			</a>
		</div>

		<div class=" flex gap-12 items-center justify-between py-6 px-6 sm:py-9 sm:px-9">
			<span>{$t(`global.lang.language`)}</span>
			<SelectLang />
		</div>
	</div>

	<BeforeNavigateLayout
		route={'/[[lang=lang]]/(with-nav)/my/(two-columns)/blacklist'}
		stateName={'blacklistModal'}
		keysToInclude={['blacklist']}
	>
		{#if $page?.state?.blacklistModal}
			<ModalWindow
				on:close={() => history.back()}
				class=" my-24 w-11/12  sm:w-3/4 md:w-4/5  xl:w-6/12 rounded-2xl p-6"
				open={true}
				closeButtonAddStyle=" text-white  mt-3 lg:mt-6 max-md:bg-zinc-500/20 max-lg:rounded-full   "
			>
				<BlockedUsersPage {...$page.state.blacklistModal} />
			</ModalWindow>
		{/if}
	</BeforeNavigateLayout>
</div>
