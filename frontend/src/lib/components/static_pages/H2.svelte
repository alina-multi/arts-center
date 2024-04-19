<script lang="ts">
    export let text: string;
    import { getContext } from 'svelte';
    const t = getContext('t');
</script>

<!-- <h1 class="text-center font-medium text-2xl tracking-widest">
    {$t({text})}
</h1> -->

<h1 class="text-center font-medium text-2xl tracking-widest">
  {$t(text)}
</h1> 