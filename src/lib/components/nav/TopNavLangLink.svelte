<script lang="ts">
	import { locale, switchLocalePath, t } from '$lib/translations';
	import { page } from '$app/stores';
	import TopNavLink from './TopNavLink.svelte';

	export let lang: string;
	$: active = locale.get() == lang;
</script>

<TopNavLink href={switchLocalePath(lang, $page.url.pathname)} preload="off" reload {active}>
	{$t(`lang.${lang}`)}
</TopNavLink>
