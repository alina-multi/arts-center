<script lang="ts">
    import { localePath} from '$lib/translations';
    import Picture from '$lib/components/atoms/Picture.svelte';
	
    

    export let data;
    const { search, query } = data;
    let page = 1;

    console.log(search)
     
    let newBatch = []; 
    $: results =  [...search.hits, ...newBatch]

    const loadMore = async () => {
        page++;
        const res = await fetch(`/api/search/${query}/${page}`);
        const search = await res.json();
        newBatch = search.hits;
    };
  
//    $: console.log(results)


</script>




<ul role="search" class="divide-y divide-gray-100">
    {#each results as user}
    <li class="flex justify-between gap-x-6 py-3">
        <div class="flex gap-x-4">
            <div class="flex-shrink-0 h-12 w-12 flex-none rounded-full bg-gray-50 overflow-hidden">
            <Picture photo={user.photo}  />
            </div>
    
          <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold leading-6 text-gray-900">{user.name}</p>
            <div class="flex gap-3">
                <p class="mt-1 truncate text-xs leading-5 text-gray-500">@{user.username}</p>
                <p class="mt-1 truncate text-xs leading-5 text-gray-500">{user.country}</p>
            </div>
           
          </div>
        </div>
      
        <div class="flex items-center gap-x-4">
            <div class="hidden sm:flex sm:flex-col sm:items-end">
                <p class="text-sm leading-5 text-gray-500">rating {user.rating} </p>
                <a href="{localePath(`/${user.username}`)}" class="mt-2 text-sm leading-5 font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    View profile
                </a>
            </div>
            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
          </div>
      </li>

    {/each}
   
  
  </ul>
  

 <!-- <ul role="list" className="divide-y divide-gray-100">
{#each results as user}
    <a href="{localePath(`/${user.username}`)}" >
      <div class="rounded-full overflow-hidden">
        <Picture photo={user.photo}  />
      </div>  
        <span>{user.name}</span>
    </a>
{/each }

<button
on:click={loadMore}
class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
>load more</button> -->




