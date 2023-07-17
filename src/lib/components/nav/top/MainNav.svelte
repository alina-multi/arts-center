<script lang="ts">
	import MobileMainNav from './MobileNav.svelte';
	import TabletMainNav from './TabletNav.svelte';
	import DesktopNav from './DesktopNav.svelte';
	import TopNav from './TopNav.svelte';
	import DarkSwitch from '../DarkSwitch.svelte';
</script>

<TopNav>
	<DesktopNav />
	<TabletMainNav  />
	<MobileMainNav />
	<DarkSwitch />
</TopNav>
