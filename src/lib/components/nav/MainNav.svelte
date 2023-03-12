<script lang="ts">
	import { localePath, t } from '$lib/translations';
	import TopNav from './TopNav.svelte';
	import TopNavLink from './TopNavLink.svelte';
	import TopNavLangLink from './TopNavLangLink.svelte';
	import DarkSwitch from './DarkSwitch.svelte';
	import logo from '$lib/images/logo.svg';
</script>

<TopNav>
	<div class="hidden sm:flex sm:space-x-8 ">
		<a href={localePath('/')} class="text-amber-700 inline-flex items-center pt-1">
			<svg class="w-[10rem] dark:fill-white dark:stroke-white">
				<use href="{logo}#logo" />
			</svg>
		</a>
		<TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
		<TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
	</div>
	<div class="flex flex-1 justify-end gap-2">
		<TopNavLangLink lang="en" />
		<TopNavLangLink lang="uk" />
		<DarkSwitch />
	</div>
</TopNav>
