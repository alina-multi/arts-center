<script lang="ts">
    import {page} from '$app/stores';

    export let href: string;
    export let exact: boolean = false;
    export let active: boolean|undefined;

    function isActive(exact, pathname, active): boolean {
        if (active !== undefined) return active;
        if (exact) return pathname === href;
        return pathname.startsWith(href);
    }
    $: computedActive = isActive(exact, $page.url.pathname, active);
</script>
<a
        {href}
        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium
        { computedActive ? 'border-amber-500 text-gray-900'
        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
        }"
>
    <slot/>
</a>