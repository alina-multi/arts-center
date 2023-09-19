<script lang="ts">
	import SideNavLink from '$lib/components/nav/side/SideNavLink.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Home } from '@steeze-ui/heroicons';
	import { t, localePath } from '$lib/translations';
	export let href: string;
</script>

<SideNavLink href={localePath(href)}
	><Icon src={Home} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />{$t(
		'global.my_links.my_profile'
	)}</SideNavLink
>
