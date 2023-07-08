<script lang="ts">
	import { localePath, t } from '$lib/translations';
	import TopNav from './TopNav.svelte';
	import TopNavLink from './TopNavLink.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import DarkSwitch from './DarkSwitch.svelte';
	import logo from '$lib/images/logo.svg';
	import UserDropdown from './UserDropdown.svelte';
	import { page } from '$app/stores';
	import SearchInput from '$lib/components/input/SearchInput.svelte';
	export let user;
</script>

<TopNav>
	<div class="hidden sm:flex sm:space-x-8">
		<a href={localePath('/')} class="text-amber-700 inline-flex items-center pt-1">
			<svg class=" h-20 w-[10rem] dark:fill-white dark:stroke-white">
				<use href="{logo}#logo" />
			</svg>
		</a>
		<TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
		<TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
	</div>
	<SearchInput />
	<div class="flex gap-2 h-full">
		{#if user}
			<UserDropdown {user} />
		{:else}
			<TopNavLink href={localePath('/login?redirect=' + $page.url.pathname)}
				>{$t('global.menu.login')}</TopNavLink
			>
			<TopNavLink href={localePath('/register')}>{$t('global.menu.register')}</TopNavLink>
		{/if}
		<TopNavLangLink lang="en" />
		<TopNavLangLink lang="uk" />
		<DarkSwitch />
	</div>
</TopNav>