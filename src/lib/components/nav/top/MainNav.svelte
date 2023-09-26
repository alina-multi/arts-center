<script lang="ts">
	import MobileMainNav from './MobileNav.svelte';
	import TabletMainNav from './TabletNav.svelte';
	import DesktopNav from './DesktopNav.svelte';
	import TopNav from './TopNav.svelte';
	import DarkSwitch from '../DarkSwitch.svelte';
	export let user;
</script>

<TopNav>
	<DesktopNav {user} />
	<TabletMainNav {user} />
	<MobileMainNav {user} />
	<DarkSwitch />
</TopNav>
