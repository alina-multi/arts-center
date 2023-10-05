<script lang="ts">
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import LoginLink from '../LoginLink.svelte';
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import Search from '../../search/SearchDialog.svelte';
	import SearchInput from '../../search/SearchInput.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import { user, isUserLoading } from '$lib/stores/auth';
</script>

<div class="hidden sm:max-xl:flex items-center w-full max-lg:justify-between">
	<div class="flex items-center gap-3 text-black">
		<SideBarNavigation />
		<Logo />
		<svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" class="h-4 mt-0.5">
			<rect width="30" height="8" fill="#0057B7" />
			<rect width="30" height="8" y="8" fill="#FFD700" />
		</svg>
	</div>

	<div class="hidden lg:block w-[429px] pl-9"><SearchInput /></div>

	<div class="flex items-center gap-6 h-full flex-1  justify-end ml-9">
		{#if !$isUserLoading}
			<div class="lg:hidden flex justify-center"><Search /></div>

			<AddWorkButton />

			{#if $user}
				<UserDropdown user={$user} />
			{:else}
				<LoginLink />
			{/if}
		{/if}
	</div>
</div>
