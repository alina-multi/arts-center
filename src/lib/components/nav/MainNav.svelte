<script lang="ts">
    import {localePath, switchLocalePath, locale} from '$lib/translations';
    import {page} from '$app/stores';
    import {t} from '$lib/translations';
    import TopNav from "$lib/components/nav/TopNav.svelte";
    import TopNavLink from "$lib/components/nav/TopNavLink.svelte";
</script>
<TopNav>
    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
        <TopNavLink href="{localePath('/')}">{$t('global.menu.gallery')}</TopNavLink>
        <TopNavLink href={localePath('/users')}>{$t('global.menu.users')}</TopNavLink>
    </div>
    <div class="flex flex-1 justify-end gap-2">
        <TopNavLink href={switchLocalePath('en', $page.url.pathname)} data-sveltekit-preload-data="off">
            {$t('lang.en')}
        </TopNavLink>
        <TopNavLink href={switchLocalePath('uk', $page.url.pathname)} data-sveltekit-preload-data="off">
            {$t('lang.uk')}
        </TopNavLink>
    </div>
</TopNav>