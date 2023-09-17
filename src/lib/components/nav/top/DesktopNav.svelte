<script lang="ts">
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import LoginLink from '../LoginLink.svelte';
	import { localePath, t } from '$lib/translations';
	import TopNavLink from '../TopNavLink.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import { page } from '$app/stores';
	import SearchInput from '$lib/components/search/SearchInput.svelte';
	import Logo from '$lib/components/atoms/Logo.svelte';

	import FooterDropdown from '$lib/components/footer/FooterDropdown.svelte';
	let user = $page.data.currentUser;
</script>

<div class="hidden xl:flex items-center w-full h-full gap-6">
	<div class="flex items-center gap-6">
		<FooterDropdown />
		<Logo />
	</div>
	<TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
	<TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
	<SearchInput />
	<AddWorkButton />
	{#if user}
		<UserDropdown {user} />
	{:else}
		<LoginLink />
	{/if}
</div>
