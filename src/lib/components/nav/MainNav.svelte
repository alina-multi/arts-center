<script lang="ts">
    import {localePath} from '$lib/translations';
    import {t} from '$lib/translations';
    import TopNav from "$lib/components/nav/TopNav.svelte";
    import TopNavLink from "$lib/components/nav/TopNavLink.svelte";
    import TopNavLangLink from "$lib/components/nav/TopNavLangLink.svelte";
</script>
<TopNav>
    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
        <a href="/" class="text-amber-700 inline-flex items-center text-2xl">arts.center</a>
        <TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
        <TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
    </div>
    <div class="flex flex-1 justify-end gap-2">
        <TopNavLangLink lang="en"/>
        <TopNavLangLink lang="uk"/>
    </div>
</TopNav>