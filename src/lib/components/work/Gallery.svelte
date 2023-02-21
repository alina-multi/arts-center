<script lang="ts">
    import WorkPreview from '$lib/components/work/WorkPreview.svelte';
    export let gallery;
</script>

<ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-5">
    {#each gallery as work}
        <WorkPreview {work}/>
    {/each}
</ul>

