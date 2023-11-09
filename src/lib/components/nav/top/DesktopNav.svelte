<script lang="ts">
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import LoginLink from '../LoginLink.svelte';
	import { localePath, t } from '$lib/translations';
	import TopNavLink from '../TopNavLink.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import SearchInput from '$lib/components/search/SearchInput.svelte';
	import Logo from '$lib/components/atoms/Logo.svelte';
	import FooterDropdown from '$lib/components/footer/FooterDropdown.svelte';
	import { user, isUserLoading } from '$lib/stores/auth';
	import BellButton from '../BellButton.svelte';
	import UaFlag from '../UaFlag.svelte';
</script>

<div class="hidden xl:flex items-center w-full h-full gap-6">
	<div class="flex items-center gap-6 flex-none">
		<FooterDropdown />
		<Logo />
		<UaFlag />
	</div>
	<TopNavLink exact href={localePath('/tag/all/popular')}>{$t('global.menu.gallery')}</TopNavLink>

	<TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>

	<SearchInput />

	<div class=" items-center flex gap-6 justify-end flex-1">
		{#if !$isUserLoading}
			<AddWorkButton />

			{#if $user}
				<BellButton />
				<UserDropdown/>
			{:else}
				<LoginLink />
			{/if}
		{/if}
	</div>
</div>
