<script lang="ts">
	import AddWorkLink from '../AddWorkLink.svelte';
	import LoginLink from '../LoginLink.svelte';
	import { localePath, t } from '$lib/translations';
	import TopNavLink from '../TopNavLink.svelte';
	import TopNavLangLink from '../TopNavLangLink.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import { page } from '$app/stores';
	import SearchInput from '$lib/components/input/SearchInput.svelte';
	import Logo from '$lib/components/atoms/Logo.svelte';
	export let breakpoint = 'lg';
	let user = $page.data.currentUser;
</script>

<div class="hidden {breakpoint}:flex items-center w-full h-full gap-6">
	<Logo />
	<TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
	<TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>

	<SearchInput />

	{#if user}
		<UserDropdown {user} />
	{:else}
		<AddWorkLink />
		<LoginLink />
	{/if}
	<div class="flex gap-3 h-full">
		<TopNavLangLink lang="en" />
		<TopNavLangLink lang="uk" />
	</div>
</div>
