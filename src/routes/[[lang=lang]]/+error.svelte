<script lang="ts">
    import { page } from '$app/stores';
    import MainNav from '$lib/components/nav/top/MainNav.svelte';
    import cat from '$lib/images/cat-icons.svg';
</script>


<MainNav />
<main class="container mx-auto px-3 min-h-screen">

  <div class="flex items-center justify-center py-14 text-zinc-800 gap-12 dark:text-zinc-300">
    <svg class="h-96 w-96 fill-zinc-800 dark:fill-zinc-300">
        <use href="{cat}#icon-cat-not-found" />
    </svg>
    <div class="p-6">
        <h1 class="text-9xl">{$page.status}</h1>
        <h2 class="text-4xl">  {$page.error.message}</h2>
       
    </div>
  </div>
</main>

