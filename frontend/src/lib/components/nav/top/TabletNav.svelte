<script lang="ts">
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import LoginLink from '../LoginLink.svelte';
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import Search from '../../search/SearchDialog.svelte';
	import SearchInput from '../../search/SearchInput.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	import { user, isUserLoading } from '$lib/stores/auth';
	import UaFlag from '../UaFlag.svelte';
	import BellButton from '../BellButton.svelte';
	import ChatButton from '$lib/components/thread/ChatButton.svelte';
</script>

<div class="hidden sm:max-xl:flex items-center w-full max-lg:justify-between">
	<div class="flex items-center gap-3 text-black">
		<SideBarNavigation />
		<Logo />
		<UaFlag />
	</div>

	<div class="hidden lg:block pl-9 flex-1"><SearchInput /></div>

	<div class="flex items-center gap-6 lg:w-[300px] h-full justify-end ml-9 max-md:mr-3">
		{#if !$isUserLoading}
			<div class="lg:hidden flex justify-center"><Search /></div>

			<div class="hidden md:flex"><AddWorkButton /></div>

			{#if $user}
			<ChatButton />
				<BellButton />
				<UserDropdown />
			{:else}
				<LoginLink />
			{/if}
		{/if}
	</div>
</div>
