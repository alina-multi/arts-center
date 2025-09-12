<script lang="ts">
	import MobileMainNav from './MobileNav.svelte';
	import TabletMainNav from './TabletNav.svelte';
	import DesktopNav from './DesktopNav.svelte';
	import TopNav from './TopNav.svelte';
</script>

<TopNav>
	<DesktopNav />
	<TabletMainNav />
	<MobileMainNav />
</TopNav>
