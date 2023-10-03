<script lang="ts">
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import LoginLink from '../LoginLink.svelte';
	import { localePath, t } from '$lib/translations';
	import TopNavLink from '../TopNavLink.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import SearchInput from '$lib/components/search/SearchInput.svelte';
	import Logo from '$lib/components/atoms/Logo.svelte';
	import FooterDropdown from '$lib/components/footer/FooterDropdown.svelte';
	import { user } from '$lib/stores/auth';
</script>

<div class="hidden xl:flex items-center w-full h-full gap-6">
	<div class="flex items-center gap-6 flex-none">
		<FooterDropdown />
		<Logo />
		<svg xmlns="http://www.w3.org/2000/svg" width='30' height='16' class="h-4 mt-0.5">
			<rect width="30" height="8" fill="#0057B7"/>
			<rect width="30" height="8" y="8" fill="#FFD700"/>
		</svg>
	</div>
	<TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
	<TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
	<SearchInput />

	<AddWorkButton />
	{#if $user}
		<UserDropdown user={$user} />
	{:else}
		<LoginLink />
	{/if}
</div>
