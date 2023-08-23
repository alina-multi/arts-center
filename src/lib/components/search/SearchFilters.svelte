<script lang="ts">
    export let query:string = '',
    options: { title: string; total: number, path:string }[] = [];
 
</script>

<section aria-labelledby="filter-heading">
    <h2 id="filter-heading" class="sr-only">Filters</h2>
    <div class=" flex flex-col divide-y dark:divide-zinc-800 ">

<div  class="pt-3 px-6 pb-3   w-full  bg-gray-100 dark:bg-zinc-900  text-gray-800 dark:text-zinc-400  ">
    Found for <span class="underline ">{query}</span>
</div>



    {#each options as {title, total, path} (title)}
    <a
    href="/search/{path}/{query}"
    class="group py-3 px-6 w-full text-gray-800 dark:text-white flex items-center justify-between gap-3 hover:text-gray-900 "
>
    <div class="flex gap-3 items-center">
        <span class="text-sm text-black dark:text-white">{title}</span>
        <span>-</span>
        <span class=" group-hover:underline text-gray-500"> {total} results </span>
    </div>
</a>
    {/each}


        
    </div>
</section>