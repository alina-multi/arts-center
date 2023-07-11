<script lang="ts">
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import SearchDialog from '../SearchDialog.svelte';
	import AddWorkLink from '../AddWorkLink.svelte';
</script>

<div class=" flex sm:hidden items-center justify-between w-full">
	<div class="flex gap-3">
		<SideBarNavigation />
		<Logo />
	</div>
	<div class="flex gap-3">
		<SearchDialog />
		<span class=" hidden min-[500px]:inline-flex"><AddWorkLink /></span>
	</div>
</div>
