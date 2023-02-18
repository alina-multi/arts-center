<script lang="ts">
    import WorkPreview from '$lib/components/work/WorkPreview.svelte';
    export let gallery;
</script>

<ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    {#each gallery as work}
        <WorkPreview {work}/>
    {/each}
</ul>

