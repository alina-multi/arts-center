<script lang=ts>
    import { Icon } from '@steeze-ui/svelte-icon'
    	import { MagnifyingGlass } from '@steeze-ui/heroicons';
        let open = false;

        function onChange(event) {
            console.log(event.target.value);
            open = true;
        }
        
</script>



  <div class="relative mt-2 flex items-center w-full px-12">
    <input on:input={onChange}  type="text" name="search" id="search" placeholder="Search..." class="block w-full rounded-full border-0 py-1.5 pl-8 text-gray-900 shadow-sm ring-1  ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
    <div class="absolute inset-y-0 left-12 flex p-2">
   
      <Icon src={MagnifyingGlass} class="text-gray-400 h-5 w-5" />
    </div>
    {#if open}
    <div class="absolute top-0 mt-12  z-50 bg-white rounded-md shadow-lg w-96">
      <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Account settings</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Support</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">License</a>
        <form method="POST" action="#">
          <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
            Sign out
          </button>
        </form>
      </div>
    </div>
  {/if}
  </div>

 
