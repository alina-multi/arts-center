<script lang="ts">
    import type { PageData } from './$types';

    export let data: PageData;
</script>
<h1 class="text-2xl font-bold">Gallery category</h1>
<ul>
    <li>Tag: {data.tag}</li>
    <li>Filters: {data.filters}</li>
</ul>
