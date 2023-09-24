<script lang="ts">
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import SearchDialog from '../../search/SearchDialog.svelte';
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
</script>

<div class=" flex sm:hidden items-center justify-between w-full">
	<div class="flex items-center gap-1.5">
		<SideBarNavigation />
		<Logo />
		<img src="/flag_ua.jpg" alt="ua" class="h-4 mt-0.5" />
	</div>
	<div class="flex gap-3">
		<SearchDialog />
		<span class=" hidden min-[500px]:inline-flex"><AddWorkButton /></span>
	</div>
</div>
