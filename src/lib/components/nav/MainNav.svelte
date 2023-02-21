<script lang="ts">
    import {localePath} from '$lib/translations';
    import {t} from '$lib/translations';
    import TopNav from "./TopNav.svelte";
    import TopNavLink from "./TopNavLink.svelte";
    import TopNavLangLink from "./TopNavLangLink.svelte";
    import DarkSwitch from "./DarkSwitch.svelte";
</script>
<TopNav>
    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
        <a href={localePath('/')} class="text-amber-700 inline-flex items-center text-2xl dark:text-amber-200">arts.center</a>
        <TopNavLink exact href={localePath('/')}>{$t('global.menu.gallery')}</TopNavLink>
        <TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
    </div>
    <div class="flex flex-1 justify-end gap-2">
        <TopNavLangLink lang="en"/>
        <TopNavLangLink lang="uk"/>
        <DarkSwitch/>
    </div>
</TopNav>