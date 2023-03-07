<script lang="ts">
export let tags = [ { name:'Abstract', href: '/' }, { name:'Illustration', href: '/'},{ name:'Abstract', href: '/' }, { name:'Illustration', href: '/'}];
</script>


    <div class=" flex items-center justify-start flex-wrap gap-1 lg:gap-3 text-xs md:text-base lg:text-base border px-3 py-3 dark:rounded-md bg-gray-100 dark:text-gray-100 dark:bg-gray-900 dark:border-transparent">
    
    {#each tags as tag}
    <div class="w-1 h-1 md:h-2 md:w-2 rounded-full bg-amber-500 first-of-type:hidden"/> 	
    
    <a  href={tag.href} class="bg-white px-3 py-1 rounded-md hover:border border hover:shadow-md dark:bg-gray-800 dark:border-transparent dark:hover:border-gray-600">   
        {tag.name}</a>	
        

   
    {/each}
  

</div>
