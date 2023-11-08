<script lang="ts">
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import SearchDialog from '../../search/SearchDialog.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import LoginLink from '../LoginLink.svelte';
	import { user, isUserLoading } from '$lib/stores/auth';
</script>

<div class=" flex sm:hidden items-center justify-between w-full gap-6">
	<div class="flex items-center gap-3">
		<SideBarNavigation user={$user} />
		<Logo />
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="30"
			height="16"
			class="h-4 mt-0.5 hidden min-[500px]:flex"
		>
			<rect width="30" height="8" fill="#0057B7" />
			<rect width="30" height="8" y="8" fill="#FFD700" />
		</svg>
	</div>
	<span class="inline-flex min-[500px]:hidden"><SearchDialog /></span>
	{#if !$isUserLoading}
		<div class=" gap-6 mr-3 hidden min-[500px]:flex">
			<SearchDialog />

			{#if $user}
				<UserDropdown user={$user} />
			{:else}
				<LoginLink />
			{/if}
		</div>
	{/if}
</div>
