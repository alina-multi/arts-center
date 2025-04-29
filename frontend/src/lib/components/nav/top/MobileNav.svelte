<script lang="ts">
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import SearchDialog from '../../search/SearchDialog.svelte';
	import UaFlag from '../UaFlag.svelte';
	import ChatButton from '$lib/components/thread/ChatButton.svelte';
	import { user } from '$lib/stores/auth';
</script>

<div class=" flex sm:hidden items-center justify-between w-full gap-3 xs:gap-6">
	<div class="flex items-center gap-3">
		<div class="relative flex">
			<SideBarNavigation />
			{#if $user && $user.unread > 0}
				<span
					class="absolute -right-1 -top-1 bg-red-500 text-white text-xs font-medium rounded-full px-1 min-w-5 h-5 leading-3 flex justify-center items-center"
				>
					{$user?.unread}
				</span>
			{/if}
		</div>
		<Logo />

		<UaFlag />
	</div>

	<div class="flex items-center gap-3 xs:mr-3">
		<SearchDialog />
		<ChatButton />
	</div>
</div>
