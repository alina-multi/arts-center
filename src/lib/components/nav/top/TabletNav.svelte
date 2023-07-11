<script lang="ts">
	import AddWorkLink from '../AddWorkLink.svelte';
	import LoginLink from '../LoginLink.svelte';
	import Logo from '../../atoms/Logo.svelte';
	import { page } from '$app/stores';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import Search from '../SearchDialog.svelte';
	import SearchInput from '../../input/SearchInput.svelte';
	import UserDropdown from '../UserDropdown.svelte';
	export let breakpoint = 'sm:max-lg';
	let user = $page.data.currentUser;
</script>

<div class="hidden {breakpoint}:flex items-center justify-between w-full">
	<div class="flex items-center gap-3 text-black">
		<SideBarNavigation />
		<Logo />
	</div>

	<div class="flex items-center gap-3 md:gap-6">
		<div class="hidden lg:block w-96"><SearchInput /></div>
		<div class="lg:hidden flex justify-center"><Search /></div>
		<div class="flex items-center gap-3 md:gap-6 h-full">
			<AddWorkLink />
			{#if user}
				<UserDropdown {user} />
			{:else}
				<LoginLink />
			{/if}
		</div>
	</div>
</div>
