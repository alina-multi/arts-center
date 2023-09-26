<script lang="ts">
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import LoginLink from '../LoginLink.svelte';
	import Logo from '../../atoms/Logo.svelte';
	import { page } from '$app/stores';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import Search from '../../search/SearchDialog.svelte';
	import SearchInput from '../../search/SearchInput.svelte';
	import UserDropdown from '../UserDropdown.svelte';

	let user = $page.data.currentUser;
</script>

<div class="hidden sm:max-xl:flex items-center justify-between w-full">
	<div class="flex items-center gap-3 text-black">
		<SideBarNavigation />
		<Logo />
		<svg xmlns="http://www.w3.org/2000/svg" width='30' height='16' class="h-4 mt-0.5">
			<rect width="30" height="8" fill="#0057B7"/>
			<rect width="30" height="8" y="8" fill="#FFD700"/>
		</svg>
	</div>
	<div class="hidden lg:flex w-96"><SearchInput /></div>
	<div class="flex items-center gap-3 md:gap-6">
		<div class="lg:hidden flex justify-center"><Search /></div>
		<div class="flex items-center gap-3 md:gap-6 h-full">
			<AddWorkButton />
			{#if user}
				<UserDropdown {user} />
			{:else}
				<LoginLink />
			{/if}
		</div>
	</div>
</div>
