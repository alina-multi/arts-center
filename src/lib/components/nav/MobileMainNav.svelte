<script lang="ts">
	import TopNav from './TopNav.svelte';
	import DarkSwitch from './DarkSwitch.svelte';
	import Logo from '../atoms/Logo.svelte';
	import SideBarNavigation from './SideBarNavigation.svelte';
	import Search from './Search.svelte';
	export let user;
</script>

<TopNav>
	<div class="flex gap-3 text-black">
		<SideBarNavigation {user} />
		<Logo />
	</div>
	<div class="flex gap-3 h-full">
		<Search />
		<DarkSwitch />
	</div>
</TopNav>
