<script lang="ts">
	import { type AvailableLocales, switchLocalePath } from '$lib/translations';
	import { page } from '$app/stores';
	import TopNavLink from './TopNavLink.svelte';
	import { getContext } from 'svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let lang: AvailableLocales;
	let active = false;
	$: active = $locale == lang;
</script>

<TopNavLink
	on:click={() => localStorage.setItem('lang', lang)}
	href={switchLocalePath($locale, lang, $page.url.pathname)}
	preload="off"
	reload
	{active}
>
	{$t(`lang.${lang}`)}
</TopNavLink>
