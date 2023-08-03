<script lang="ts">
  export let value, min, max, name;
</script>

<input class="block px-6 w-full rounded-full border sm:text-sm dark:bg-zinc-900 dark:border-0" type="date" {value} {min} {max} {name} />