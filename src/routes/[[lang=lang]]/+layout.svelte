<script lang="ts">
    import '$lib/css/app.css';

    import MainNav from "$lib/components/nav/MainNav.svelte";
</script>

<div class="app">
    <MainNav/>
    <main class="mt-3 p-3">
        <slot/>
    </main>
</div>
