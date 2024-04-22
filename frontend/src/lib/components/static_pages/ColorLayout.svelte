<script lang="ts">
export let details: string;
</script>

<div class="{details}  dark:bg-zinc-900 dark:border-y dark:border-zinc-800 py-9">
    <slot/>
</div>