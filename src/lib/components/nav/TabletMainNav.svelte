<script lang="ts">
	import Button from '../atoms/Button.svelte';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Bars4, MagnifyingGlass, XMark, ChevronDown, PlusCircle } from '@steeze-ui/heroicons';
	import TopNav from './TopNav.svelte';
	import DarkSwitch from './DarkSwitch.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import Logo from '../atoms/Logo.svelte';
	import { page } from '$app/stores';
	import Avatar from '../atoms/Avatar.svelte';
	import SideBarNavigation from './SideBarNavigation.svelte';
	import Search from './Search.svelte';
    import TopNavLink from './TopNavLink.svelte';
    import { localePath, t } from '$lib/translations';
	export let user;

</script>

<TopNav>
	<div class="flex gap-3 text-black">
		<SideBarNavigation {user} />
		<Logo />
     
	</div>

	<div class="flex gap-3 h-full">
		<Search />
		<div class="flex items-center gap-3 h-full">
			<a
				href="/login?redirect={$page.url.pathname}"
				class=" flex items-center text-sm border border-amber-800 rounded-full px-3 py-1 bg-amber-700 text-white shadow-sm"
			>
				<span class="sr-only">ADD WORK</span>
				<Icon src={PlusCircle} theme="solid" class="h-5 w-5" aria-hidden="true" />
				<span class="ml-2">ADD WORK</span>
			</a>

			<a
				href="/register"
				class=" text-sm inline-flex border rounded-full px-3 py-1 border-black text-black shadow-sm"
				>LOGIN</a
			>
		</div>
		<DarkSwitch />
	</div>
</TopNav>


