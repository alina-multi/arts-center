<script lang="ts">
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import SearchDialog from '../../search/SearchDialog.svelte';
	import BellButton from '../BellButton.svelte';
	import UaFlag from '../UaFlag.svelte';
	import ChatButton from '$lib/components/thread/ChatButton.svelte';
</script>

<div class=" flex sm:hidden items-center justify-between w-full gap-3 xs:gap-6">
	<div class="flex items-center gap-3">
		<SideBarNavigation />
		<Logo />

		<UaFlag />
	</div>

	<div class="flex items-center min-xs:hidden gap-3 xs:mr-3">
		<SearchDialog />
		<ChatButton />
		<BellButton />
	</div>
</div>
