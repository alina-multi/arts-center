<script lang="ts">
       import { localePath } from '$lib/translations';
    export let query = '',
    totalUsers,
    totalWorks;
 
</script>

<section aria-labelledby="filter-heading">
    <h2 id="filter-heading" class="sr-only">Filters</h2>
    <div class=" flex flex-col divide-y dark:divide-zinc-800 ">

<div  class="pt-3 px-6 pb-3   w-full  bg-gray-100  text-gray-800 dark:text-white  ">
    Found for <span class="underline ">{query}</span>
</div>

    <!-- <a href="/" class=""> Authors</a>
    <a href="/" class=""> Works</a> -->

    <a
    href='/search/users/{query}'

     class="py-3 px-6 w-full   text-gray-800 dark:text-white flex items-center justify-between gap-3 hover:text-gray-900 ">

    <div 
   
    class="flex gap-3 items-center">
        <span class="text-sm text-black dark:text-white">ARTISTS</span>
        <span>-</span>
        <span class=" text-gray-500">   {totalUsers} results </span>
       
    </div>

</a>

<a 
href='/search/works/{query}'
class="py-3 px-6  w-full   text-gray-800 dark:text-white flex items-center justify-between gap-3 hover:text-gray-900 ">

    <div class="flex gap-3 items-center">
        <span class="text-sm text-black dark:text-white">WORKS</span>
        <span>-</span>
        <span class="text-gray-500">
            {totalWorks} results
        </span>
     
   
        
    </div>

</a>


        
    </div>
</section>