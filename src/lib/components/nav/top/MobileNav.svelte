<script lang="ts">
	import Logo from '../../atoms/Logo.svelte';
	import SideBarNavigation from '../SideBarNavigation.svelte';
	import SearchDialog from '../../search/SearchDialog.svelte';
	import AddWorkButton from '../../atoms/buttons/AddWorkButton.svelte';
	import { user } from '$lib/stores/auth';
</script>

<div class=" flex sm:hidden items-center justify-between w-full">
	<div class="flex items-center gap-1.5">
		<SideBarNavigation user={$user} />
		<Logo />
		<svg xmlns="http://www.w3.org/2000/svg" width='30' height='16' class="h-4 mt-0.5">
			<rect width="30" height="8" fill="#0057B7"/>
			<rect width="30" height="8" y="8" fill="#FFD700"/>
		</svg>
	</div>
	<div class="flex gap-3">
		<SearchDialog />
		<span class=" hidden min-[500px]:inline-flex"><AddWorkButton /></span>
	</div>
</div>
