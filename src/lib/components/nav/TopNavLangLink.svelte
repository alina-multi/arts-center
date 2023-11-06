<script lang="ts">
	import { locale, switchLocalePath, t } from '$lib/translations';
	import { page } from '$app/stores';
	import TopNavLink from './TopNavLink.svelte';

	export let lang: string;
	let active = false;
	$: active = $locale == lang;
</script>

<TopNavLink
	on:click={() => localStorage.setItem('lang', lang)}
	href={switchLocalePath(lang, $page.url.pathname)}
	preload="off"
	reload
	{active}
>
	{$t(`lang.${lang}`)}
</TopNavLink>
